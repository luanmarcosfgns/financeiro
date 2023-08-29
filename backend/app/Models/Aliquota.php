<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aliquota extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["nome","descritivo","ativo","business_id"];

    protected $searchableFields = ["*"];

    
    
    public function AliquotasItem()
    {
        return $this->hasMany(AliquotasItem::class);
    }
    public function Servico()
    {
        return $this->hasMany(Servico::class);
    }


}