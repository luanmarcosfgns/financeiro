<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServicosAnexo extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["anexo","extensao","tipo","servico_id"];

    protected $searchableFields = ["*"];

    
   public function Servico()
    {
        return $this->belongsTo(Servico::class);
    }
    


}