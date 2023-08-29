<?php

namespace App\Http\Controllers;

use App\Models\AliquotasItem;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class AliquotasItemController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [
            'nome'=>['required','max:255','string'],
            'aliquota_id'=>['required'],
            'descritivo'=>['nullable','max:4294967295','string'],
            'porcentagem'=>['required','numeric'],
        ]
        );
    }else{
        $request->validate([
            'nome'=>['required','max:255','string'],
            'aliquota_id'=>['required'],
            'descritivo'=>['nullable','max:4294967295','string'],
            'porcentagem'=>['required','numeric'],
        ]);
    }
        return $request->only(["nome","aliquota_id","descritivo","porcentagem"]);
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
        $aliquotas_items = AliquotasItem::search($search)
            ->paginate(1000);

        return response()->json($aliquotas_items);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store",$request);

        $aliquotas_item = AliquotasItem::create($validated);

         return response()->json($aliquotas_item);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id):JsonResponse
    {
        $aliquotas_item = AliquotasItem::find($id);

       return response()->json($aliquotas_item);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $aliquotas_item = AliquotasItem::find($id);
        $validated = $this->validated("update",$request);

        $aliquotas_item->update($validated);

         return response()->json($aliquotas_item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $aliquotas_item = AliquotasItem::find($id);
        $aliquotas_item->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

}