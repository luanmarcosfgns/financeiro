<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pergunta extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["business_id","entrevista_id","enunciado","opcoes","ordem","tipo_resposta"];

    protected $searchableFields = ["*"];

    
   public function Entrevista()
    {
        return $this->belongsTo(Entrevista::class);
    }
    
    public function Resposta()
    {
        return $this->hasMany(Resposta::class);
    }


}