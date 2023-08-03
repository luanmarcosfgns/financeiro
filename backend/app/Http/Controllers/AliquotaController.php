<?php

namespace App\Http\Controllers;

use App\Models\Aliquota;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class AliquotaController extends Controller
{
    public function validated($type, $request)
    {
        if ($type == "store") {
            $request->validate(
                [
                    'ativo' => ['required', 'boolean'],
                    'descritivo' => ['nullable', 'max:4294967295', 'string'],
                    'nome' => ['required', 'max:255', 'string'],
                ]
            );
        } else {
            $request->validate([
                'ativo' => ['required', 'boolean'],
                'descritivo' => ['nullable', 'max:4294967295', 'string'],
                'nome' => ['required', 'max:255', 'string'],
            ]);
        }
        return $request->only(["ativo", "descritivo", "nome"]);
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
            ->paginate(5);

        return response()->json($aliquotas);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store", $request);
        $validated['business_id'] = auth()->user()->business_id;
        $aliquota = Aliquota::create($validated);

        return response()->json($aliquota);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $aliquota = Aliquota::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->first();

        return response()->json($aliquota);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
                $id
    ): JsonResponse
    {

        $aliquota = Aliquota::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->first();
        $validated = $this->validated("update", $request);

        $aliquota->update($validated);

        return response()->json($aliquota);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $aliquota = Aliquota::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->first();
        $aliquota->delete();

        return response()->json(["success" => true, "message" => "Removed success"]);
    }

}
