<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use App\Models\Resposta;
use App\Models\Servico;
use App\Models\User;
use App\Models\Venda;
use App\Models\VendasServico;
use App\Util\DataFormat;
use Illuminate\Http\Request;

class CotationController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            $contato = Contato::where('contatos.cnpj_cpf', DataFormat::unmask($request->lead[1]))->first();
            if (empty($contato)) {
                $contato = Contato::create([
                    'nome' => $request->lead[0],
                    'cnpj_cpf' => $request->lead[1],
                    'telefone' => $request->lead[2],
                    'celular' => $request->lead[3],
                    'email' => $request->lead[4],
                    'profissao' => $request->lead[5],
                    'business_id' => $user->business_id,
                ]);
            }



            $venda = Venda::create([
                'contato_id' => $contato->id,
                'descritivo' => 'Venda Feita por meio do formulário',
                'business_id' => $user->business_id,
                'user_id' => $user->id,
                'tipo' => 'orcamento',
                'status' => 'novo'
            ]);
            VendasServico::create([
                'venda_id' => $venda->id,
                'servico_id' => $request->servico_id,
            ]);
            foreach ($request->perguntas as $pergunta) {
                Resposta::create([
                    'pergunta_id' => $pergunta[0],
                    'resposta' => $pergunta[1],
                    'contato_id' => $contato->id,
                    'venda_id' => $venda->id,
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }


    }
}
