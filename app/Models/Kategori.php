<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori'; 
    
    protected $fillable = [
        'title',
        'page',
        'slug',
    ];

    public function getBlog()
    {
        return $this->hasMany(Blog::class, 'kategori_id', 'id');
    }

    public function getNews()
    {
        return $this->hasMany(News::class, 'kategori_id', 'id');
    }

    public function getUrunler()
    {
        return $this->hasMany(Urunler::class, 'kategori_id', 'id');
    }
}
