<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class VendaController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [

            'contato_id'=>['required'],
            'descritivo'=>['nullable','max:4294967295','string'],
            'impostos_totais'=>['required','json'],
            'valor_total'=>['required','numeric'],
        ]
        );
    }else{
        $request->validate([

            'contato_id'=>['required'],
            'descritivo'=>['nullable','max:4294967295','string'],
            'impostos_totais'=>['required','json'],
            'valor_total'=>['required','numeric'],
        ]);
    }
        return $request->only(["contato_id","descritivo","impostos_totais","valor_total"]);
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
        $vendas = Venda::search($search)
            ->where('business_id', auth()->user()->business_id)
            ->paginate(5);

        return response()->json($vendas);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store",$request);
        $validated['business_id'] = auth()->user()->business_id;
        $venda = Venda::create($validated);

         return response()->json($venda);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id):JsonResponse
    {
        $venda = Venda::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->firstOrFail();

       return response()->json($venda);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $venda = Venda::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->firstOrFail();
        $validated = $this->validated("update",$request);

        $venda->update($validated);

         return response()->json($venda);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $venda = Venda::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->firstOrFail();
        $venda->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

}
