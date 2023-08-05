<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\VendasPagamento;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class VendasPagamentoController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [
            'desconto'=>['required','numeric'],
            'impostos'=>['required','json'],
            'tipo_pagamento'=>['required','max:255','string'],
            'valor'=>['required','numeric'],
            'venda_id'=>['required'],
        ]
        );
    }else{
        $request->validate([
            'desconto'=>['required','numeric'],
            'impostos'=>['required','json'],
            'tipo_pagamento'=>['required','max:255','string'],
            'valor'=>['required','numeric'],
            'venda_id'=>['required'],
        ]);
    }
        return $request->only(["desconto","impostos","tipo_pagamento","valor","venda_id"]);
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
        $vendasPagamentos =VendasPagamento::search($search)->where('venda_id',$request->venda_id)->paginate(5);;



        return response()->json($vendasPagamentos);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store",$request);

        $vendas_pagamento = VendasPagamento::create($validated);

         return response()->json($vendas_pagamento);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id):JsonResponse
    {
        $vendas_pagamento = VendasPagamento::findOrFail($id);

       return response()->json($vendas_pagamento);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $vendas_pagamento = VendasPagamento::findOrFail($id);
        $validated = $this->validated("update",$request);

        $vendas_pagamento->update($validated);

         return response()->json($vendas_pagamento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $vendas_pagamento = VendasPagamento::findOrFail($id);
        $vendas_pagamento->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

}
