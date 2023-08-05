<?php
        namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Session extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ["business_id","descritivo","image_video","nome","parent_id"];

    protected $searchableFields = ["*"];

    
    


}