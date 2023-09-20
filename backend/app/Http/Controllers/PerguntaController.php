<?php

namespace App\Http\Controllers;

use App\Models\Entrevista;
use App\Models\Pergunta;
use App\Models\Venda;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class PerguntaController extends Controller
{
    public function validated($type, $request)
    {
        if ($type == "store") {
            $request->validate(
                [

                    'enunciado' => ['required', 'max:4294967295', 'string'],
                    'opcoes' => ['required'],
                    'ordem' => ['required'],
                    'tipo_resposta' => ['required', 'max:10'],
                ]
            );
        } else {
            $request->validate([

                'enunciado' => ['required', 'max:4294967295', 'string'],
                'opcoes' => ['required'],
                'ordem' => ['required'],
                'tipo_resposta' => ['required', 'max:10'],
            ]);
        }
        return $request->only(["business_id", "entrevista_id", "enunciado", "opcoes", "ordem", "tipo_resposta"]);
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
        $perguntas = Pergunta::search($search)
            ->where('entrevista_id', $request->entrevista_id)
            ->paginate(1000);

        return response()->json($perguntas);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store", $request);
        $validated['business_id'] = auth()->user()->business_id;
        $pergunta = Pergunta::create($validated);

        return response()->json($pergunta);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $pergunta = Pergunta::find($id);

        return response()->json($pergunta);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
                $id
    ): JsonResponse
    {

        $pergunta = Pergunta::find($id);
        $validated = $this->validated("update", $request);
        $pergunta->update($validated);
        return response()->json($pergunta);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $pergunta = Pergunta::find($id);
        $pergunta->delete();

        return response()->json(["success" => true, "message" => "Removed success"]);
    }

    public function view($servico_id): JsonResponse
    {
        $perguntas = Entrevista::join('perguntas', 'entrevistas.id', 'perguntas.entrevista_id')
            ->where('entrevistas.servico_id', $servico_id)
            ->where('entrevistas.ativo', true)
            ->select([
                'perguntas.id',
                'perguntas.enunciado',
                'perguntas.tipo_resposta',
                'perguntas.ordem',
                'perguntas.opcoes',

            ])->get();
        $perguntasCount = count($perguntas);
        for($i=0;$i<$perguntasCount;$i++){
            $perguntas[$i]->opcoes =  json_decode($perguntas[$i]->opcoes);
        }

        return response()->json($perguntas);
    }

    public function list(Request $request): JsonResponse
    {

        $search = $request->get("search", "");
        if ($search == null) {
            $search = "";
        }
        $perguntas = Venda::join('respostas','respostas.venda_id','vendas.id')
            ->join('perguntas','perguntas.id','respostas.pergunta_id')
            ->select([
                'perguntas.enunciado',
                'respostas.resposta',
                'perguntas.ordem'
            ])
            ->orderBY('perguntas.ordem')
            ->where('vendas.id',$request->venda_id)->paginate(1000);


        return response()->json($perguntas);
    }
}
