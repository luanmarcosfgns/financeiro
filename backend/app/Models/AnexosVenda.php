<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnexosVenda extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["nome","anexo","venda_id","selecionado","porcentagem_franquiadora","valor_premio","melhor_opcao","descritivo","porcentagem_corretora","porcentagem_vendedor","comissao",'desconto'];

    protected $searchableFields = ["*"];


   public function Venda()
    {
        return $this->belongsTo(Venda::class);
    }



}
