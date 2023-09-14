<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ContatoController extends Controller
{
    public function validated($type, $request)
    {
        if ($type == "store") {
            $request->validate(
                [
                    'nome' => ['required', 'max:300', 'string'],
                    'razao' => ['nullable', 'max:300', 'string'],
                    'nascimento' => ['nullable', 'date'],
                    'estado_civil' => ['nullable', 'max:10'],
                    'sexo' => ['nullable', 'max:9'],
                    'rg_ie' => ['nullable', 'max:300', 'string'],
                    'cnpj_cpf' => ['required', 'max:18', 'string'],
                    'telefone' => ['required', 'max:30', 'string'],
                    'celular' => ['required', 'max:30', 'string'],
                    'email' => ['required', 'max:150', 'string'],
                    'descritivo' => ['nullable', 'max:4294967295', 'string'],
                    'ativo' => ['required', 'boolean'],

                    'profissao' => ['required', 'max:150', 'string'],
                    'endereco_id' => ['nullable'],
                ]
            );
        } else {
            $request->validate([
                'nome' => ['required', 'max:300', 'string'],
                'razao' => ['nullable', 'max:300', 'string'],
                'nascimento' => ['nullable', 'date'],
                'estado_civil' => ['nullable', 'max:10'],
                'sexo' => ['nullable', 'max:9'],
                'rg_ie' => ['nullable', 'max:300', 'string'],
                'cnpj_cpf' => ['required', 'max:18', 'string'],
                'telefone' => ['required', 'max:30', 'string'],
                'celular' => ['required', 'max:30', 'string'],
                'email' => ['required', 'max:150', 'string'],
                'descritivo' => ['nullable', 'max:4294967295', 'string'],
                'ativo' => ['required', 'boolean'],
                'profissao' => ['required', 'max:150', 'string'],
                'endereco_id' => ['nullable'],
            ]);
        }
        return $request->only(["nome", "razao", "nascimento", "estado_civil", "sexo", "rg_ie", "cnpj_cpf", "telefone", "celular", "email", "descritivo", "ativo", "business_id", "profissao", "endereco_id"]);
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
        $contatos = Contato::search($search)
            ->where('business_id', auth()->user()->business_id)
            ->paginate(1000);

        return response()->json($contatos);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store", $request);
        $validated['business_id'] = auth()->user()->business_id;
        $contato = Contato::create($validated);

        return response()->json($contato);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $contato = Contato::find($id);

        return response()->json($contato);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
                $id
    ): JsonResponse
    {

        $contato = Contato::find($id);
        $validated = $this->validated("update", $request);

        $contato->update($validated);

        return response()->json($contato);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $contato = Contato::find($id);
        $contato->delete();

        return response()->json(["success" => true, "message" => "Removed success"]);
    }

    public function list()
    {
        $model = Contato::select('id as code', DB::raw('CONCAT(id,"-",nome," (",cnpj_cpf,")","\n") as label'))
            ->where('business_id', auth()->user()->business_id);
        if (!empty(request()->search)) {
            $model->search(request()->search);
        }
        if (!empty(request()->id)) {
            return response()->json($model->find(request()->id));
        }
        $data = $model->get();

        return response()->json($data);
    }

}
