<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendasServico extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        "venda_id",
        "servico_id",
        "desconto",
        "porcentagem_franquiadora",
        "valor_premio",
        "porcentagem_corretora",
        "porcentagem_vendedor",
        'comissao'
    ];

    protected $searchableFields = ["*"];


    public function Venda()
    {
        return $this->belongsTo(Venda::class);
    }

    public function Servico()
    {
        return $this->belongsTo(Servico::class);
    }


}
