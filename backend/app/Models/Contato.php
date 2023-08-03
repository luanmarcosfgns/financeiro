<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contato extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["nome","nascimento","estado_civil","sexo","rg_ie","cnpj_cpf","endereco","numero","bairro","cidade","cep","telefone","celular","email","descritivo","ativo","business_id"];

    protected $searchableFields = ["*"];

    
    
    public function Venda()
    {
        return $this->hasMany(Venda::class);
    }


}