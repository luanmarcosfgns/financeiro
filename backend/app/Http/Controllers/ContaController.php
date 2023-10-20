<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ContaController extends Controller
{
    public function validated($type, $request)
    {
        if ($type == "store") {
            $request->validate(
                [
                    'valor' => ['required', 'numeric'],
                    'tipo' => ['required', 'max:7'],
                    'nome' => ['required', 'max:100', 'string'],
                    'mes' => ['required'],

                ]
            );
        } else {
            $request->validate([
                'valor' => ['required', 'numeric'],
                'tipo' => ['required', 'max:7'],
                'nome' => ['required', 'max:100', 'string'],
                'mes' => ['required'],

            ]);
        }
        return $request->only(["valor", "tipo", "nome", "mes", "user_id"]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {

        $contas = Conta::where('user_id', auth()->user()->id)->where(DB::raw('YEAR(created_at)'), Carbon::now()->year);

        if (!empty($request->mes)) {
            $contas =  $contas->where('mes', $request->mes);
        }

        $data = $contas->get();

        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->validated("store", $request);
        $validated['user_id'] = $request->user()->id;
        $conta = Conta::create($validated);

        return response()->json($conta);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $conta = Conta::find($id);

        return response()->json($conta);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
                $id
    ): JsonResponse
    {

        $conta = Conta::find($id);
        $validated = $this->validated("update", $request);

        $conta->update($validated);

        return response()->json($conta);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $conta = Conta::find($id);
        $conta->delete();

        return response()->json(["success" => true, "message" => "Removed success"]);
    }

    public function changePago($id)
    {
        $conta = Conta::find($id);
        if($conta->pago){
            $conta->pago = false;
        }else{
            $conta->pago = true;
        }
        $conta->save();
    }

}
