<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AliquotasItem extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["aliquota_id","descritivo","nome","porcentagem"];

    protected $searchableFields = ["*"];

    
   public function Aliquota()
    {
        return $this->belongsTo(Aliquota::class);
    }
    


}