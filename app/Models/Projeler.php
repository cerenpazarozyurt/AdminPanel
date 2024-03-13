<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeler extends Model
{
    use HasFactory;

    protected $table = 'projeler'; 
    
    protected $fillable = [
        'name',
        'contents',
        'header_photos',
    ];

    public function getPhoto(){  
        return $this->hasMany(Photos::class, 'content_id','id' ); 
    }
}
