<?php

namespace App\Http\Controllers;

use App\Models\Aliquota;
use App\Models\AliquotasItem;
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
            ->select([
                'contatos.nome as contato_nome',
                'vendas.id as id',
                'vendas.tipo as tipo',
                'vendas.status as status',
                DB::raw('DATE_FORMAT(vendas.created_at,"%d/%m/%Y %H:%i:%S") as created'),
                DB::raw('(SUM(vendas_servicos.preco)-SUM(vendas_servicos.desconto)) as total')

            ])->groupBy('vendas.id');

        if (auth()->user()->type == 'revendedor') {
            $model = $model->where('vendas.user_id', auth()->user()->id);
        }

        $search = $request->get("search", "");
        if ($search == null) {
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
                        'preco' => $servico['preco'],
                        'quantidade' => $servico['quantidade'],
                        'desconto' => $servico['desconto'] ?? 0,
                        'impostos' => '[]',

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
                'vendas_servicos.venda_id',
                'vendas_servicos.servico_id',
                'servicos.nome as servicos_nome',
                'vendas_servicos.preco',
                'vendas_servicos.desconto',
                'vendas_servicos.comissao',
                DB::raw(' "" as aliquotas')
            ])->where('vendas_servicos.venda_id', $venda->id)->get();
        $countServicos = count($servicos);

        for ($i = 0; $i < $countServicos; $i++) {

            $servicos[$i]->aliquotas = Servico::join('aliquotas', 'aliquotas.id', 'servicos.aliquota_id')
                ->join('aliquotas_items', 'aliquotas_items.aliquota_id', 'aliquotas.id')
                ->select(['aliquotas_items.id',
                    DB::raw('CONCAT(aliquotas_items.id,
                    "-",
                    aliquotas_items.nome,
                    " desconto maximo %:",
                    aliquotas_items.desconto_porcentagem,
                    " comissao %:",aliquotas_items.porcentagem_comissao) as message'),
                    'aliquotas_items.desconto_porcentagem',
                    'aliquotas_items.porcentagem_comissao',
                    'aliquotas_items.valor'
                ])
                ->where('servicos.id', $servicos[$i]->servico_id)
                ->get();
        }
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

        $venda->update($validated);

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
        $venda = Venda::find($id);
        $venda->tipo = 'venda';
        $venda->save();
        return response()->json(["success" => true]);

    }

}
