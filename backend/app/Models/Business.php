<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'business';
    protected $fillable = ["fantasia", "razao", "cnpj_cpf", "ie_rg", "endereco", "numero", "cep", "telefone", "celular"];

    protected $searchableFields = ["*"];


}
