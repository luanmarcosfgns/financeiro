<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entrevista extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["ativo","business_id","descritivo","nome","servico_id"];

    protected $searchableFields = ["*"];

    
   public function Servico()
    {
        return $this->belongsTo(Servico::class);
    }
    
    public function PerguntasEntrevista()
    {
        return $this->hasMany(PerguntasEntrevista::class);
    }


}