<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servico extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["nome","descritivo","ecommerce","preco","aliquota_id","categoria_id","ativo","business_id"];

    protected $searchableFields = ["*"];

    
   public function Aliquota()
    {
        return $this->belongsTo(Aliquota::class);
    }
   public function Categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    
    public function Entrevista()
    {
        return $this->hasMany(Entrevista::class);
    }
    public function ServicosAnexo()
    {
        return $this->hasMany(ServicosAnexo::class);
    }


}