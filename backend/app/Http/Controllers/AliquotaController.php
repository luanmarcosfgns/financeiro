<?php

namespace App\Http\Controllers;

use App\Models\Aliquota;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class AliquotaController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [
            'nome'=>['required','max:255','string'],
            'descritivo'=>['nullable','max:4294967295','string'],
            'ativo'=>['required','boolean'],
        ]
        );
    }else{
        $request->validate([
            'nome'=>['required','max:255','string'],
            'descritivo'=>['nullable','max:4294967295','string'],
            'ativo'=>['required','boolean'],
        ]);
    }
        return $request->only(["nome","descritivo","ativo","business_id"]);
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
        $aliquotas = Aliquota::search($search)
            ->where('business_id', auth()->user()->business_id)
            ->paginate(1000);

        return response()->json($aliquotas);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store",$request);
        $validated['business_id'] = auth()->user()->business_id;
        $aliquota = Aliquota::create($validated);

         return response()->json($aliquota);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id):JsonResponse
    {
        $aliquota = Aliquota::find($id);

       return response()->json($aliquota);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $aliquota = Aliquota::find($id);
        $validated = $this->validated("update",$request);

        $aliquota->update($validated);

         return response()->json($aliquota);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $aliquota = Aliquota::find($id);
        $aliquota->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

    public function list(): JsonResponse
    {

        $categorias = Aliquota::where('business_id', auth()->user()->business_id)
            ->where('ativo', true)
            ->select('id', 'nome as message')
            ->get('message', 'id');
        return response()->json($categorias);
    }

}
