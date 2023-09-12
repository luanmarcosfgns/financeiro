<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venda extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["contato_id","descritivo","valor_total","impostos_totais","business_id"];

    protected $searchableFields = ["*"];

    
   public function Contato()
    {
        return $this->belongsTo(Contato::class);
    }
    
    public function Resposta()
    {
        return $this->hasMany(Resposta::class);
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