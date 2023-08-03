<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ServicoController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [
            'aliquota_id'=>['nullable'],
            'ativo'=>['required','boolean'],
            'categoria_id'=>['nullable'],
            'descritivo'=>['nullable','max:4294967295','string'],
            'nome'=>['required','max:255','string'],
            'preco'=>['required','numeric'],
        ]
        );
    }else{
        $request->validate([
            'aliquota_id'=>['nullable'],
            'ativo'=>['required','boolean'],
            'categoria_id'=>['nullable'],
            'descritivo'=>['nullable','max:4294967295','string'],
            'nome'=>['required','max:255','string'],
            'preco'=>['required','numeric'],
        ]);
    }
        return $request->only(["aliquota_id","ativo","business_id","categoria_id","descritivo","nome","preco"]);
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
            ->paginate(5);

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
        $servico = Servico::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->first();

       return response()->json($servico);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $servico = Servico::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->first();
        $validated = $this->validated("update",$request);

        $servico->update($validated);

         return response()->json($servico);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $servico = Servico::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->first();
        $servico->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

}
