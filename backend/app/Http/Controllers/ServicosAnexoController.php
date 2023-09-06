<?php

namespace App\Http\Controllers;

use App\Models\ServicosAnexo;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ServicosAnexoController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [
            'anexo'=>['required','max:6990507'],

            'tipo'=>['required','max:9'],
            'servico_id'=>['required'],
        ]
        );
    }else{
        $request->validate([
            'anexo'=>['required','max:6990507'],
            'tipo'=>['required','max:9'],
            'servico_id'=>['required'],
        ]);
    }
        return $request->only(["anexo","tipo","servico_id"]);
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
        $servicos_anexos = ServicosAnexo::search($search)
            ->paginate(1000);

        return response()->json($servicos_anexos);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store",$request);
        $servicos_anexo = ServicosAnexo::create($validated);

         return response()->json($servicos_anexo);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id):JsonResponse
    {
        $servicos_anexo = ServicosAnexo::find($id);

       return response()->json($servicos_anexo);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $servicos_anexo = ServicosAnexo::find($id);
        $validated = $this->validated("update",$request);

        $servicos_anexo->update($validated);

         return response()->json($servicos_anexo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $servicos_anexo = ServicosAnexo::find($id);
        $servicos_anexo->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

}
