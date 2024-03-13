<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Kategori;
use App\Models\Photos;
use RealRashid\SweetAlert\Facades\Alert;

class NewsController extends Controller
{
    function index(){
        $news = News::get();
        $categories= Kategori::all();

        return view("panel.news.index", compact('news','categories')); //compact fonksiyonu ile belirtilen değişkenler, görünüm dosyasında kullanılmak üzere hazırlanır.
    }

    //kayıt oluşturulacağı sayfaya yönlendirme işlemleri için;
    public function create(Request $request){
        $categories = Kategori::all();
        return view("panel.news.create" , compact('categories'));
    }

    //create fonksiyonunun formundan gelen verileri işleyerek bir kayıt oluşturur ve kalıcı depolama alanına kaydetme işlemleri için;
    public function store(Request $request){
        $data= $request -> all();

        if($request->hasFile('kapak_foto')){ 
            $file=$request->file('kapak_foto');
        
            //dosyanın yeni adını oluşturmak için;
            try{
                $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                $foto_adi = str_replace("(", "", $foto_adi); 
                $foto_adi = str_replace(")", "", $foto_adi);
                $url = $file->move(public_path('assets/img/news_photo'), $foto_adi); 
                $data["header_img"] = $foto_adi;
            }   
            catch (Exception $e){ 
                return redirect()->back()->with("news", $e);
            }
        }

        //istekten gelen bilgileri veritabanına kaydetemek için;
        $news = new News();
        $news->title = $request->title;
        $news->contents = $request->contents;
        $news->slug = $request->slug;
        $news->kategori_id = $request->kategori_id;
        $news->header_img = $data["header_img"];
        $news->save();
        

        if ($request->hasFile('images')) { 
    
            $file = $request->file('images');

            try {
                foreach ($request->file('images') as $file) { //Eğer dosyalar yüklenmişse, her bir yüklenen dosya için bir döngü başlatılır.

                    $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                    $foto_adi = str_replace("(", "", $foto_adi);
                    $foto_adi = str_replace(")", "", $foto_adi);

                    $url = $file->move(public_path('assets/img/news_photo'), $foto_adi);

                    $foto = new photos();  
                    $foto->content_id= $news->id; 
                    $foto->url = $foto_adi;
                    $foto->page = "news";
                    $foto->save();
                }
            } catch (Exception $e){
                Alert::success('Hata',$e->getMessage());
                return back();
            }
        }
        if($news){
            Alert::success('Başarılı','Haber kaydedildi.');
            return back();
        }else{
            Alert::error('Hata','Haber kaydedilemedi.');
            return back();
        }
    }

    function edit($id){
        $news=News::find($id);
        $categories = Kategori::all();
        $resimler = Photos::where([
            ["content_id", $news->id],
            ["page", "news"]])->get();
        return view("panel.news.edit", compact("news", 'categories', "resimler"));
    }

    //güncelleme işlemi için;
    function update(Request $request, $id){
        $news=News::find($id);
        $data = $request->all();

        if ($request->hasFile('kapak_foto')) {

            $file = $request->file('kapak_foto');

            try{
                $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                $foto_adi = str_replace("(", "", $foto_adi);
                $foto_adi = str_replace(")", "", $foto_adi);

                $url = $file->move(public_path('assets/img/news_photo'), $foto_adi);

                $data["header_img"] = $foto_adi;

            }catch (Exception $e){
                return redirect()->back()->with("news", $e);
            }
        }

        $news->title = $request->title;
        $news->contents = $request->contents;
        $news->slug = $request->slug;
            if (isset($data["header_img"])) {
                $news->header_img = $data["header_img"];
            }
            $news->save();

        if ($request->hasFile('images')) {
    
            $file = $request->file('images');

            try {
                foreach ($request->file('images') as $file) {

                    $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                    $foto_adi = str_replace("(", "", $foto_adi);
                    $foto_adi = str_replace(")", "", $foto_adi);

                    $url = $file->move(public_path('assets/img/news_photo'), $foto_adi);

                    $foto = new photos();
                    $foto->content_id= $news->id;
                    $foto->url = $foto_adi;
                    $foto->page = "news";
                    $foto->save();
                }
            } catch (Exception $e){
                Alert::success('Hata',$e->getMessage());
                return back();
            }
        }
        if($news){
            Alert::success('Başarılı','Güncelleme kaydedildi.');
            return back();
        }else{
            Alert::error('Hata','Güncelleme kaydedilemedi.');
            return back();
        }
    }
    
    function delete($id){
        $news = News::find($id);

        if($news->delete()){
            Alert::success('Başarılı','Haber Silindi')->toast();
            return back();
        }else {
            Alert::error('Hata','Haber Silinemedi.');
            return back();
        }
    }
}