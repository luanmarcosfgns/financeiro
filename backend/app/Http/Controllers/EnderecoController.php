<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class EnderecoController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [
            'contato_id'=>['required'],
            'endereco'=>['required','max:400','string'],
            'numero'=>['required','max:10','string'],
            'bairro'=>['required','max:150','string'],
            'cidade'=>['required','max:150','string'],
            'cep'=>['required','max:10','string'],

        ]
        );
    }else{
        $request->validate([
            'contato_id'=>['required'],
            'endereco'=>['required','max:400','string'],
            'numero'=>['required','max:10','string'],
            'bairro'=>['required','max:150','string'],
            'cidade'=>['required','max:150','string'],
            'cep'=>['required','max:10','string'],

        ]);
    }
        return $request->only(["contato_id","endereco","numero","bairro","cidade","cep","business_id"]);
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
        $enderecos = Endereco::search($search)
            ->where('contato_id',$request->id)
            ->paginate(1000);

        return response()->json($enderecos);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store",$request);
        $validated['business_id'] = auth()->user()->business_id;
        $endereco = Endereco::create($validated);

         return response()->json($endereco);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id):JsonResponse
    {
        $endereco = Endereco::find($id);

       return response()->json($endereco);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $endereco = Endereco::find($id);
        $validated = $this->validated("update",$request);

        $endereco->update($validated);

         return response()->json($endereco);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $endereco = Endereco::find($id);
        $endereco->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

}
