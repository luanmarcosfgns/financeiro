<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servico extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["aliquota_id","ativo","business_id","categoria_id","descritivo","nome","preco"];

    protected $searchableFields = ["*"];

    
   public function Aliquota()
    {
        return $this->belongsTo(Aliquota::class);
    }
   public function Categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    
    public function ServicosAnexo()
    {
        return $this->hasMany(ServicosAnexo::class);
    }


}