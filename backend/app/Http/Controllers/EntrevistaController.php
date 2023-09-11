<?php

namespace App\Http\Controllers;

use App\Models\Entrevista;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class EntrevistaController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [
            'ativo'=>['required','boolean'],
            'descritivo'=>['required','max:4294967295','string'],
            'nome'=>['required','max:150','string'],
            'servico_id'=>['required'],
        ]
        );
    }else{
        $request->validate([
            'ativo'=>['required','boolean'],
            'descritivo'=>['required','max:4294967295','string'],
            'nome'=>['required','max:150','string'],
            'servico_id'=>['required'],
        ]);
    }
        return $request->only(["ativo","business_id","descritivo","nome","servico_id"]);
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
        $entrevistas = Entrevista::search($search)
            ->where('servico_id',$request->servico_id)
            ->paginate(1000);

        return response()->json($entrevistas);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store",$request);
        $validated['business_id'] = auth()->user()->business_id;
        $entrevista = Entrevista::create($validated);

         return response()->json($entrevista);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id):JsonResponse
    {
        $entrevista = Entrevista::find($id);

       return response()->json($entrevista);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $entrevista = Entrevista::find($id);
        $validated = $this->validated("update",$request);

        $entrevista->update($validated);

         return response()->json($entrevista);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $entrevista = Entrevista::find($id);
        $entrevista->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

}
