<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conta extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["valor","tipo","nome","mes","user_id",'pago'];

    protected $searchableFields = ["*"];


   public function User()
    {
        return $this->belongsTo(User::class);
    }



}
