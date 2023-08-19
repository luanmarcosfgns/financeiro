<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ContatoController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [
            'ativo'=>['nullable','boolean'],
            'bairro'=>['nullable','max:150','string'],
            'celular'=>['nullable','max:30','string'],
            'cep'=>['nullable','max:10','string'],
            'cidade'=>['nullable','max:150','string'],
            'cnpj_cpf'=>['nullable','max:18','string'],
            'descritivo'=>['nullable','max:4294967295','string'],
            'email'=>['nullable','max:150','string'],
            'endereco'=>['nullable','max:400','string'],
            'estado_civil'=>['nullable','max:10'],
            'nascimento'=>['nullable','date'],
            'nome'=>['nullable','max:300','string'],
            'numero'=>['nullable','max:10','string'],
            'rg'=>['nullable','max:300','string'],
            'sexo'=>['nullable','max:9'],
            'telefone'=>['nullable','max:30','string'],
        ]
        );
    }else{
        $request->validate([
            'ativo'=>['nullable','boolean'],
            'bairro'=>['nullable','max:150','string'],
            'celular'=>['nullable','max:30','string'],
            'cep'=>['nullable','max:10','string'],
            'cidade'=>['nullable','max:150','string'],
            'cnpj_cpf'=>['nullable','max:18','string'],
            'descritivo'=>['nullable','max:4294967295','string'],
            'email'=>['nullable','max:150','string'],
            'endereco'=>['nullable','max:400','string'],
            'estado_civil'=>['nullable','max:10'],
            'nascimento'=>['nullable','date'],
            'nome'=>['nullable','max:300','string'],
            'numero'=>['nullable','max:10','string'],
            'rg'=>['nullable','max:300','string'],
            'sexo'=>['nullable','max:9'],
            'telefone'=>['nullable','max:30','string'],
        ]);
    }
        return $request->only(["ativo","bairro","celular","cep","cidade","cnpj_cpf","descritivo","email","endereco","estado_civil","nascimento","nome","numero","rg","sexo","telefone"]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {

        $search = $request->get("search", '');
        $contatos = Contato::search($search)
            ->where('business_id',auth()->user()->business_id)
            ->paginate(1000);

        return response()->json($contatos);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store",$request);
        $validated['business_id'] = auth()->user()->business_id;
        $contato = Contato::create($validated);

         return response()->json($contato);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $contato = Contato::where('id', $id)
            ->where('business_id', auth()->user()->business_id)
            ->firstOrFail();
        return response()->json($contato);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $contato =  Contato::where('id', $id)
            ->where('business_id', auth()->user()->business_id)
            ->firstOrFail();
        $validated = $this->validated("update",$request);

        $contato->update($validated);

         return response()->json($contato);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
       $contato =  Contato::where('id', $id)
        ->where('business_id', auth()->user()->business_id)
        ->firstOrFail();

        $contato->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

}
