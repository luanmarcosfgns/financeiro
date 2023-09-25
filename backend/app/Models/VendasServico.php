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
        "preco",
        "desconto",
        "comissao",
        "aliquotas_item_id",
    ];

    protected $searchableFields = ["*"];


   public function Venda()
    {
        return $this->belongsTo(Venda::class);
    }



}
