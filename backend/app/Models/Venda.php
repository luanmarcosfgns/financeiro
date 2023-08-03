<?php
        namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venda extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["contato_id","descritivo","valor_total","impostos_totais"];

    protected $searchableFields = ["*"];

    
   public function Contato()
    {
        return $this->belongsTo(Contato::class);
    }
    
    public function VendasItem()
    {
        return $this->hasMany(VendasItem::class);
    }


}