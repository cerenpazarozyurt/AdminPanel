<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        
        $blog = DB::table('blog')->count();
        $news = DB::table('news')->count();
        $urunler = DB::table('urunler')->count();
        $projeler = DB::table('projeler')->count();
        $referanslar = DB::table('referanslar')->count();
        

        return view('dashboard', compact("blog", "news", "urunler", "projeler", "referanslar")); 
    }
}
