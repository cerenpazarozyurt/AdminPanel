<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news'; 
    
    protected $fillable = [
        'title',
        'contents',
        'header_img',
        'header_photos',
        'kategori_id',
        'slug',
    ];

    public function getPhoto(){  
        return $this->hasMany(Photos::class, 'content_id','id' ); 
    }

    public function getKapak(){ 
        return $this->hasOne(Photos::class, 'content_id','id' ); 
    }

    public function getKategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}
