<?php

namespace App\Http\Controllers;

use App\Models\AnexosVenda;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class AnexosVendaController extends Controller
{
    public function validated($type, $request)
    {
        if ($type == "store") {
            $request->validate(
                [
                    'nome' => 'required|string|max:255',
                    'anexo' => 'required:10000', // Validar base64 com até 10MB
                    'venda_id' => 'required|integer',
                    'porcentagem_seguradora' => 'required|numeric',
                    'porcentagem_franquiadora' => 'required|numeric',
                    'porcentagem_maxima_vendedor' => 'required|numeric',
                    'porcentagem_minima_vendedor' => 'required|numeric',
                    'valor_premio' => 'required|numeric',
                    'melhor_opcao' => 'required|string',
                    'descritivo' => 'nullable|string',

                ]
            );
            return $request->only(["nome", "anexo", "venda_id", "selecionado", "porcentagem_seguradora", "porcentagem_franquiadora", "porcentagem_maxima_vendedor", "porcentagem_minima_vendedor", "valor_premio", "melhor_opcao", "descritivo"]);
        } else {
            return $request->only([ "selecionado"]);
        }

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
        $anexos_vendas = AnexosVenda::where('anexos_vendas.venda_id', $request->id)
            ->search($search)
            ->paginate(1000);

        return response()->json($anexos_vendas);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store", $request);

        $validated['selecionado']=false;
        $anexos_venda = AnexosVenda::create($validated);

        return response()->json($anexos_venda);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $anexos_venda = AnexosVenda::find($id);

        return response()->json($anexos_venda);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
                $id
    ): JsonResponse
    {

        $anexos_venda = AnexosVenda::find($id);
        AnexosVenda::where('venda_id',$anexos_venda->venda_id)->update([
            'selecionado'=>'0'
        ]);
        $validated = $this->validated("update", $request);

        $anexos_venda->update($validated);


        return response()->json($anexos_venda);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $anexos_venda = AnexosVenda::find($id);
        $anexos_venda->delete();

        return response()->json(["success" => true, "message" => "Removed success"]);
    }

}
