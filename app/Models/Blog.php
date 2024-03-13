<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog'; 
    
    protected $fillable = [
        'title',
        'contents',
        'header_img',
        'header_photos',
        'kategori_id',
        'slug',
    ];

    public function getPhoto(){  // ilişkili model olan Photos modelini çağırır ve bu model ile ilişkili olan fotoğrafları getirir.
        return $this->hasMany(Photos::class, 'content_id','id' ); //"bir blog yazısının birden çok fotoğrafı olabilir" ilişkisini ifade eder.
    }

    public function getKapak(){ // ilişkili model olan Photos modelini çağırır ve bu model ile ilişkili olan kapak fotoğrafını getirir.
        return $this->hasOne(Photos::class, 'content_id','id' ); //"bir blog yazısının bir kapak fotoğrafı olabilir" ilişkisini ifade eder.
    }

    public function getKategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

}
