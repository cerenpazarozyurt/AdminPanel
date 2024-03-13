<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referanslar extends Model
{
    use HasFactory;

    protected $table = 'referanslar'; 
    
    protected $fillable = [
        'name',
        'email',
    ];
}
