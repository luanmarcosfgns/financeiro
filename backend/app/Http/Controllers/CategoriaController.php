<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class CategoriaController extends Controller
{
    public function validated($type, $request)
    {
        if ($type == "store") {
            $request->validate(
                [

                    'descritivo' => ['nullable', 'max:4294967295', 'string'],
                    'nome' => ['required', 'max:255', 'string'],
                    'parent_id' => ['nullable'],
                ]
            );
        } else {
            $request->validate([

                'descritivo' => ['nullable', 'max:4294967295', 'string'],
                'nome' => ['required', 'max:255', 'string'],
                'parent_id' => ['nullable'],
            ]);
        }
        return $request->only(["descritivo", "nome", "parent_id"]);
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
        $categoriasModel = Categoria::search($search)
            ->where('business_id', auth()->user()->business_id);
        if (!empty($request->parent_id)) {
            $categoriasModel->where('parent_id', $request->parent_id);
        }
        $categoriasModel->select('categorias.id',
            'categorias.nome',
            'categorias.parent_id',
            DB::raw('CONCAT(categorias.id,".",categorias.parent_id) as item')
        )->orderBy('item');
        $categorias = $categoriasModel->paginate(1000);

        return response()->json($categorias);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store", $request);
        $validated['business_id'] = auth()->user()->business_id;
        $categoria = Categoria::create($validated);

        return response()->json($categoria);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $categoria = Categoria::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->firstOrFail();

        return response()->json($categoria);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
                $id
    ): JsonResponse
    {

        $categoria = Categoria::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->firstOrFail();
        $validated = $this->validated("update", $request);

        $categoria->update($validated);

        return response()->json($categoria);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $categoria = Categoria::where('business_id', auth()->user()->business_id)
            ->where('id', $id)->firstOrFail();
        $categoria->delete();

        return response()->json(["success" => true, "message" => "Removed success"]);
    }

    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $categorias = Categoria::where('business_id', auth()->user()->business_id)
            ->whereNotNull('parent_id')
            ->select('id', 'nome as message')
            ->get('message','id');
        return response()->json($categorias);
    }

}
