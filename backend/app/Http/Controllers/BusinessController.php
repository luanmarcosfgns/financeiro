<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class BusinessController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [
            'fantasia'=>['required','max:255','string'],
            'razao'=>['nullable','max:255','string'],
            'cnpj_cpf'=>['required','max:255','string'],
            'ie_rg'=>['nullable','max:255','string'],
            'endereco'=>['nullable','max:255','string'],
            'numero'=>['nullable','max:6','string'],
            'cep'=>['nullable','max:20','string'],
            'telefone'=>['nullable','max:20','string'],
            'celular'=>['nullable','max:20','string'],
        ]
        );
    }else{
        $request->validate([
            'fantasia'=>['required','max:255','string'],
            'razao'=>['required','max:255','string'],
            'cnpj_cpf'=>['required','max:255','string'],
            'ie_rg'=>['nullable','max:255','string'],
            'endereco'=>['nullable','max:255','string'],
            'numero'=>['nullable','max:6','string'],
            'cep'=>['nullable','max:20','string'],
            'telefone'=>['nullable','max:20','string'],
            'celular'=>['nullable','max:20','string'],
        ]);
    }
        return $request->only(["fantasia","razao","cnpj_cpf","ie_rg","endereco","numero","cep","telefone","celular"]);
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
        $business = Business::search($search)
            ->where('id',auth()->user()->business_id)
            ->paginate(1000);

        return response()->json($business);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store",$request);

        $busine = Business::create($validated);
        auth()->user()->update(['business_id'=>$busine->id]);

         return response()->json($busine);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id):JsonResponse
    {
        $busine = Business::where('id',auth()->user()->business_id)
            ->where('id',$id)
            ->firstOrFail();

       return response()->json($busine);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $busine = Business::where('id',auth()->user()->business_id)
            ->where('id',$id)
            ->firstOrFail();
        $validated = $this->validated("update",$request);

        $busine->update($validated);

         return response()->json($busine);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $busine = Business::where('id',auth()->user()->business_id)
            ->where('id',$id)
            ->firstOrFail();
        $busine->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

}
