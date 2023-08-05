<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["nome","descritivo","parent_id","business_id"];

    protected $searchableFields = ["*"];

    
    
    public function Servico()
    {
        return $this->hasMany(Servico::class);
    }


}