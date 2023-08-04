<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\VendasServico;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class VendasServicoController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [
            'impostos'=>['required','json'],
            'produto_id'=>['required'],
            'valor'=>['required','numeric'],
            'venda_id'=>['required'],
        ]
        );
    }else{
        $request->validate([
            'impostos'=>['required','json'],
            'produto_id'=>['required'],
            'valor'=>['required','numeric'],
            'venda_id'=>['required'],
        ]);
    }
        return $request->only(["impostos","produto_id","valor","venda_id"]);
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

        if (empty($request->venda_id)) {
            abort(404,'Not Found');
        }

        $countVendasPagamento = Servico::where('id',$request->venda_id)->where('business_id',auth()->user()->business_id)->count();
        if($countVendasPagamento==0){
            abort(404, 'Not Found');
        }
        $vendasServicos = VendasServico::search($search)->where('venda_id',$request->venda_id)->paginate(5);

        return response()->json($vendasServicos);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store",$request);

        $vendas_servico = VendasServico::create($validated);

         return response()->json($vendas_servico);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id):JsonResponse
    {
        $vendas_servico = VendasServico::findOrFail($id);

       return response()->json($vendas_servico);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $vendas_servico = VendasServico::findOrFail($id);
        $validated = $this->validated("update",$request);

        $vendas_servico->update($validated);

         return response()->json($vendas_servico);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $vendas_servico = VendasServico::findOrFail($id);
        $vendas_servico->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

}
