<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venda extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["business_id","contato_id","descritivo","impostos_totais","valor_total"];

    protected $searchableFields = ["*"];

    
   public function Contato()
    {
        return $this->belongsTo(Contato::class);
    }
    
    public function VendasPagamento()
    {
        return $this->hasMany(VendasPagamento::class);
    }
    public function VendasServico()
    {
        return $this->hasMany(VendasServico::class);
    }


}