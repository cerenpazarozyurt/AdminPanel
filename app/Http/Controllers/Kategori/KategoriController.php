<?php

namespace App\Http\Controllers\Kategori;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    public function index()
    {
        $categories = Kategori::all(); // Tüm kategorileri getir

        return view('panel.kategori.index', compact('categories'));
    }

    public function create(Request $request){
        $categories = Kategori::all();
        return view("panel.kategori.create" , compact('categories'));
    }

    public function store(Request $request){
        $data= $request -> all();

        //istekten gelen bilgileri veritabanına kaydetemek için;
        $categories = new Kategori();
        $categories->title = $request->title;
        $categories->page = $request->page;
        $categories->slug = $request->slug;
        $categories->save();
   
        if($categories){
            Alert::success('Başarılı','Kategori kaydedildi.')->toast();
            return back();
        }else {
            Alert::error('Hata','Kategori kaydedilemedi.');
            return back();
        }

        //return redirect()->back()->with("message","Kayıt işlemi başarılı");
    }
    
    function edit($id){
        $categories=Kategori::find($id);
        return view("panel.kategori.edit", compact("categories"));
    }

    function update(Request $request, $id){
        $categories=Kategori::find($id);
        $data = $request->all();

        $categories->title = $request->title;
        $categories->page = $request->page;
        $categories->slug = $request->slug;
        $categories->save();


        if($categories){
            Alert::success('Başarılı','Güncelleme kaydedildi.')->toast();
            return back();
        }else {
            Alert::error('Hata','Güncelleme kaydedilemedi.');
            return back();
        }
    }

    function delete($id){
        $categories = Kategori::find($id);

        if($categories->delete()){
            Alert::success('Başarılı','Kategori Silindi')->toast();
            return back();
        }else {
            Alert::error('Hata','Kategori Silinemedi.');
            return back();
        }
    }

    public function show($id)
    {
        $category = Kategorİ::find($id); // Belirli bir kategoriyi getir

        // Kategorinin ilişkili bloglarını getir
        $blog = $category->getBlog;
        $news = $category->getNews;
        $urunler = $category->getUrunler;

        return view('categories.show', compact('category', 'blog', 'news', 'urunler'));
    }
}
