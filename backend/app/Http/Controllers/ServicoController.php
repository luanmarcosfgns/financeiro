<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ServicoController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [
            'nome'=>['required','max:255','string'],
            'descritivo'=>['nullable','max:4294967295','string'],
            'ecommerce'=>['required','boolean'],
            'preco'=>['required','numeric'],
            'aliquota_id'=>['nullable'],
            'categoria_id'=>['nullable'],
            'ativo'=>['required','boolean'],
        ]
        );
    }else{
        $request->validate([
            'nome'=>['required','max:255','string'],
            'descritivo'=>['nullable','max:4294967295','string'],
            'ecommerce'=>['required','boolean'],
            'preco'=>['required','numeric'],
            'aliquota_id'=>['nullable'],
            'categoria_id'=>['nullable'],
            'ativo'=>['required','boolean'],
        ]);
    }
        return $request->only(["nome","descritivo","ecommerce","preco","aliquota_id","categoria_id","ativo","business_id"]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {

        $search = $request->get("search", "");
        if ($search == null) {
            $search = "";
        }
        $servicos = Servico::search($search)
            ->where('business_id', auth()->user()->business_id)
            ->paginate(1000);

        return response()->json($servicos);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store",$request);
        $validated['business_id'] = auth()->user()->business_id;
        $servico = Servico::create($validated);

         return response()->json($servico);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id):JsonResponse
    {
        $servico = Servico::select([
            'servicos.id',
            'servicos.nome',
            'servicos.nome as servicos_nome',
            'servicos.id as servico_id',
            'servicos.descritivo',
            'servicos.ecommerce',
            'servicos.preco',
            'servicos.aliquota_id',
            'servicos.categoria_id',
            'servicos.ativo',
            'servicos.business_id',
            'servicos.created_at',
            'servicos.updated_at',

        ])->find($id);
        $servico->aliquotas = Servico::join('aliquotas', 'aliquotas.id', 'servicos.aliquota_id')
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
            ->where('servicos.id', $servico->id)
            ->get();


       return response()->json($servico);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $servico = Servico::find($id);
        $validated = $this->validated("update",$request);

        $servico->update($validated);

         return response()->json($servico);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $servico = Servico::find($id);
        $servico->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }
    public function list()
    {
        $model = Servico::select('id as code', DB::raw('CONCAT(id,"-",nome,"\n") as label'))
            ->where('business_id', auth()->user()->business_id);
        if (!empty(request()->search)) {
            $model->search(request()->search);
        }
        if (!empty(request()->id)) {
            return response()->json($model->find(request()->id));
        }
        $data = $model->get();

        return response()->json($data);
    }

    public function link($id)
    {
        $user_id = auth()->user()->id;
        $link =str_replace('==','','/cotations/'.base64_encode('[{"servico_id":'.$id.',"user_id":'.$user_id.'}]'));
        return response()->json(['link'=>$link]);
    }
    public function view( $id):JsonResponse
    {
        $servico = Servico::select('servicos.nome')->find($id);

        return response()->json($servico);
    }




}
