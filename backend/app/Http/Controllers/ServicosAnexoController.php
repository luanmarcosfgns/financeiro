<?php

namespace App\Http\Controllers;

use App\Models\Aliquota;
use App\Models\Servico;
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
            'image_video'=>['required','max:255','string'],
            'servico_id'=>['required'],
        ]
        );
    }else{
        $request->validate([
            'image_video'=>['required','max:255','string'],
            'servico_id'=>['required'],
        ]);
    }
        return $request->only(["image_video","servico_id"]);
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
        if (empty($request->servico_id)) {
            abort(404,'Not Found');
        }

        $countServico = Servico::where('id',$request->servico_id)->where('business_id',auth()->user()->business_id)->count();
        if($countServico==0){
            abort(404, 'Not Found');
        }
        $servicos_anexos = ServicosAnexo::search($search)
            ->where('servico_id',$request->servico_id)
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
        $servicos_anexo = ServicosAnexo::findOrFail($id);

       return response()->json($servicos_anexo);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $servicos_anexo = ServicosAnexo::findOrFail($id);
        $validated = $this->validated("update",$request);

        $servicos_anexo->update($validated);

         return response()->json($servicos_anexo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $servicos_anexo = ServicosAnexo::findOrFail($id);
        $servicos_anexo->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

}
