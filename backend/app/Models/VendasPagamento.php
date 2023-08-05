<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendasPagamento extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["desconto","impostos","tipo_pagamento","valor","venda_id"];

    protected $searchableFields = ["*"];

    
   public function Venda()
    {
        return $this->belongsTo(Venda::class);
    }
    


}