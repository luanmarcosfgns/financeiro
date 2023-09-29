<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnexosVenda extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["nome","anexo","venda_id","selecionado","porcentagem_seguradora","porcentagem_franquiadora","porcentagem_maxima_vendedor","porcentagem_minima_vendedor","valor_premio","melhor_opcao","descritivo"];

    protected $searchableFields = ["*"];

    
   public function Venda()
    {
        return $this->belongsTo(Venda::class);
    }
    


}