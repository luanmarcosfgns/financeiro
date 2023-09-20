<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resposta extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["contato_id","pergunta_id","resposta","venda_id"];

    protected $searchableFields = ["*"];


   public function Contato()
    {
        return $this->belongsTo(Contato::class);
    }
   public function pergunta()
    {
        return $this->belongsTo(Pergunta::class);
    }
   public function Venda()
    {
        return $this->belongsTo(Venda::class);
    }



}
