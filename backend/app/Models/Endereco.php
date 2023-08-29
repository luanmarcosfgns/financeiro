<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Endereco extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["contato_id","endereco","numero","bairro","cidade","cep","business_id"];

    protected $searchableFields = ["*"];

    
   public function Contato()
    {
        return $this->belongsTo(Contato::class);
    }
    


}