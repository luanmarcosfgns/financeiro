<?php

namespace App\Http\Controllers;

use App\Models\Aliquota;
use App\Models\AliquotasItem;
use App\Models\AnexosVenda;
use App\Models\Servico;
use App\Models\Venda;
use App\Models\VendasServico;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class VendaController extends Controller
{
    public function validated($type, $request)
    {
        if ($type == "store") {
            $request->validate(
                [
                    'contato_id' => ['required'],
                    'descritivo' => ['nullable', 'max:4294967295', 'string'],


                ]
            );
        } else {
            $request->validate([
                'contato_id' => ['required'],
                'descritivo' => ['nullable', 'max:4294967295', 'string'],

            ]);
        }
        return $request->only(["contato_id", "descritivo", "servicos", "status", "tipo"]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $model = Venda::where('vendas.business_id', auth()->user()->business_id)
            ->join('vendas_servicos', 'vendas.id', '=', 'vendas_servicos.venda_id')
            ->join('contatos', 'contatos.id', '=', 'vendas.contato_id')
            ->join('users', 'users.id', '=', 'vendas.user_id')
            ->select([
                'contatos.nome as contato_nome',
                'users.name as user_name',
                'vendas.id as id',
                DB::raw('IF((select count(*) from anexos_vendas where anexos_vendas.venda_id=vendas.id and anexos_vendas.selecionado=1) > 0,"Sim","Não") as selecionado'),
                'vendas.tipo as tipo',
                'vendas.status as status',
                DB::raw('DATE_FORMAT(vendas.created_at,"%d/%m/%Y %H:%i:%S") as created'),

            ])
            ->orderBy('vendas.id','desc')
            ->orderBy('selecionado','desc')
            ->groupBy('vendas.id')
            ->groupBy('users.name')
            ->groupBy('vendas.tipo')
            ->groupBy('vendas.status')
            ->groupBy('vendas.created_at')
            ->groupBy('contatos.nome');

        if (auth()->user()->type == 'vendedor') {
            $model = $model->where('vendas.user_id', auth()->user()->id);
        }

        $search = $request->get("search", "");
        if ($search != null) {
            $model->where('contatos.nome', 'like', '%' . $search . '%');
        }
        if (!empty($request->tipo)) {
            $model->where('vendas.tipo', $request->tipo);
        }

        $vendas = $model->paginate(1000);

        return response()->json($vendas);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $validated = $this->validated("store", $request);
            $validated['business_id'] = auth()->user()->business_id;
            $validated['user_id'] = auth()->user()->id;
            $venda = Venda::create($validated);

            $servicos = $validated['servicos'] ?? false;
            if ($validated['servicos']) {
                foreach ($servicos as $servico) {
                    VendasServico::create([
                        'venda_id' => $venda['id'],
                        'servico_id' => $servico['id'],
                    ]);
                }

            }
            DB::commit();

            return response()->json($venda);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage() . $e->getLine()]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $venda = Venda::find($id);
        $servicos = VendasServico::join('servicos', 'servicos.id', 'vendas_servicos.servico_id')
            ->select([
                'vendas_servicos.id',
                'vendas_servicos.venda_id',
                'vendas_servicos.servico_id',
                'servicos.nome as servicos_nome',
                'vendas_servicos.porcentagem_franquiadora',
                'vendas_servicos.porcentagem_corretora',
                'vendas_servicos.porcentagem_vendedor',
                'vendas_servicos.comissao',
                'vendas_servicos.valor_premio',
                'vendas_servicos.desconto',

                DB::raw(' "" as aliquotas')
            ])->where('vendas_servicos.venda_id', $venda->id)->get();


        $venda->servicos = $servicos;


        return response()->json($venda);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
                $id
    ): JsonResponse
    {

        $venda = Venda::find($id);
        $validated = $this->validated("update", $request);
        $validated['tipo']='venda';
        $venda->update($validated);


        $servicos = $validated['servicos'] ?? false;
        if ($servicos) {
            foreach ($servicos as $servico) {
                $anexoVenda = AnexosVenda::where('venda_id',$id)->first();
               $venda =  VendasServico::where('servico_id',$servico['servico_id'])->where('venda_id',$id)->first();
               $venda->update([
                   'desconto' => $servico['desconto'] ?? 0,
                   'porcentagem_vendedor' => $anexoVenda['porcentagem_vendedor'] ?? 0,
                   'porcentagem_corretora' => $anexoVenda['porcentagem_corretora'] ?? 0,
                   'valor_premio' => $anexoVenda['valor_premio'] ?? 0,
                   'comissao' => $anexoVenda['comissao'] ?? 0,
                   'porcentagem_franquiadora' => $anexoVenda['porcentagem_franquiadora'] ?? 0,
                ]);
            }

        }

        return response()->json($venda);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $venda = Venda::find($id);
        VendasServico::where('venda_id', $venda->id)->delete();
        $venda->delete();


        return response()->json(["success" => true, "message" => "Removed success"]);
    }

    public function tipoVendaTransform($id)
    {
        $venda = Venda::findOrFail($id);
        $venda->tipo = 'venda';
        $vendaAnexo =  AnexosVenda::where('venda_id',$id)->first();
        $vendaServico =  VendasServico::where('venda_id',$id)->first();
        $vendaServico->porcentagem_seguradora= $vendaAnexo->porcentagem_seguradora;
        $vendaServico->porcentagem_franquiadora= $vendaAnexo->porcentagem_franquiadora;
        $vendaServico->porcentagem_maxima_vendedor= $vendaAnexo->porcentagem_maxima_vendedor;
        $vendaServico->porcentagem_minima_vendedor= $vendaAnexo->porcentagem_minima_vendedor;
        $vendaServico->valor_premio= $vendaAnexo->valor_premio;
        $vendaServico->save();
        $venda->save();
        return response()->json(["success" => true]);

    }

}
