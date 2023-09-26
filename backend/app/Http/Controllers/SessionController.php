<?php

namespace App\Http\Controllers;

use App\Models\Aliquota;
use App\Models\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class SessionController extends Controller
{
    public function validated($type, $request)
    {
        if ($type == "store") {
            $request->validate(
                [
                    'nome' => ['required', 'max:255', 'string'],
                    'descritivo' => ['nullable', 'max:4294967295', 'string'],
                    'image_video' => ['nullable', 'max:4294967295', 'string'],
                    'parent_id' => ['nullable'],
                    'link' => ['nullable'],

                ]
            );
        } else {
            $request->validate([
                'nome' => ['required', 'max:255', 'string'],
                'descritivo' => ['nullable', 'max:4294967295', 'string'],
                'image_video' => ['nullable', 'max:4294967295', 'string'],
                'parent_id' => ['nullable'],
                'link' => ['nullable'],

            ]);
        }
        return $request->only(["nome", "descritivo", "image_video", "parent_id", 'link']);
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
            ->select([
                'sessions.id',
                'sessions.nome',
                'sessions.descritivo',
                'sessions.image_video',
                'sessions.parent_id',
                'sessions.business_id',
                'sessions.created_at',
                DB::raw('IF(sessions.parent_id IS NULL,CONCAT(sessions.id,0),CONCAT(sessions.parent_id,sessions.id)) as item')
            ])->orderBy('item')->paginate(1000);

        return response()->json($sessions);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store", $request);
        $validated['business_id'] = auth()->user()->business_id;

        $session = Session::create($validated);

        return response()->json($session);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $session = Session::find($id);

        return response()->json($session);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
                $id
    ): JsonResponse
    {

        $session = Session::find($id);
        $validated = $this->validated("update", $request);

        $session->update($validated);

        return response()->json($session);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $session = Session::find($id);
        $session->delete();

        return response()->json(["success" => true, "message" => "Removed success"]);
    }

    public function list(): JsonResponse
    {

        $sessions = Session::where('business_id', auth()->user()->business_id)
            ->select('id', 'nome as message')
            ->get('message', 'id');
        return response()->json($sessions);
    }

    public function listSite($id): JsonResponse
    {
        $id = base64_decode($id);
        $sessions = Session::where('business_id', $id)
            ->whereNull('parent_id')
            ->select(
                'id',
                'nome',
                'descritivo',
                'image_video',
                'parent_id',
                DB::raw('"panel" as type'),
                DB::raw('"" as sub_sessions'),
            )
            ->get();
        $countSessions = count($sessions);

        for ($i = 0; $i < $countSessions; $i++) {
            $sessions[$i]->sub_sessions = Session::where('business_id', $id)
                ->where('parent_id',$sessions[$i]->id)
                ->select(
                    'id',
                    'nome',
                    'descritivo',
                    'image_video',
                    'link',
                )
                ->get();
            if (count($sessions[$i]->sub_sessions)>0){
                $sessions[$i]->type='carrossel';
            }

        }
        return response()->json($sessions);
    }


}
