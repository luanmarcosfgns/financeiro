<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class SessionController extends Controller
{
    public function validated($type,$request){
    if($type=="store"){
        $request->validate(
        [
            'descritivo'=>['nullable','max:4294967295','string'],
            'image_video'=>['nullable','max:4294967295','string'],
            'nome'=>['required','max:255','string'],
            'parent_id'=>['nullable'],
        ]
        );
    }else{
        $request->validate([
            'descritivo'=>['nullable','max:4294967295','string'],
            'image_video'=>['nullable','max:4294967295','string'],
            'nome'=>['required','max:255','string'],
            'parent_id'=>['nullable'],
        ]);
    }
        return $request->only(["descritivo","image_video","nome","parent_id"]);
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
        $sessions = Session::search($search)
            ->where('business_id', auth()->user()->business_id)
            ->paginate(1000);

        return response()->json($sessions);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store",$request);
        $validated['business_id'] = auth()->user()->business_id;
        $session = Session::create($validated);

         return response()->json($session);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id):JsonResponse
    {
        $session = Session::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->firstOrFail();

       return response()->json($session);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
       Request $request,
       $id
    ): JsonResponse{

        $session = Session::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->firstOrFail();
        $validated = $this->validated("update",$request);
        $session->update($validated);

         return response()->json($session);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $session = Session::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->firstOrFail();
        $session->delete();

       return response()->json(["success"=>true,"message"=>"Removed success"]);
    }

}
