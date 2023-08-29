<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contato extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["nome","razao","nascimento","estado_civil","sexo","rg_ie","cnpj_cpf","telefone","celular","email","descritivo","ativo","business_id","profissao","endereco_id"];

    protected $searchableFields = ["*"];

    
   public function Endereco()
    {
        return $this->belongsTo(Endereco::class);
    }
    
    public function Resposta()
    {
        return $this->hasMany(Resposta::class);
    }
    public function Venda()
    {
        return $this->hasMany(Venda::class);
    }


}