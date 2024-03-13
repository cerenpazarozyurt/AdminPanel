<?php

namespace App\Http\Controllers\Urunler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Urunler;
use App\Models\Kategori;
use App\Models\Photos;
use RealRashid\SweetAlert\Facades\Alert;

class UrunlerController extends Controller
{
    function index(){
        $urunler = Urunler::get();
        $categories= Kategori::all();

        return view("panel.urunler.index", compact('urunler','categories'));
    }

    public function create(Request $request){
        $categories = Kategori::all();
        return view("panel.urunler.create" , compact('categories'));
    }

    public function store(Request $request){
        $data= $request -> all();

        if($request->hasFile('kapak_foto')){ 
            $file=$request->file('kapak_foto');
        
            try{
                $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                $foto_adi = str_replace("(", "", $foto_adi); 
                $foto_adi = str_replace(")", "", $foto_adi);
                $url = $file->move(public_path('assets/img/urunler_photo'), $foto_adi); 
                $data["header_img"] = $foto_adi;
            }   
            catch (Exception $e){ 
                return redirect()->back()->with("urunler", $e);
            }
        }

        //istekten gelen bilgileri veritabanına kaydetemek için;
        $urunler = new Urunler();
        $urunler->title = $request->title;
        $urunler->contents = $request->contents;
        $urunler->price = $request->price;
        $urunler->slug = $request->slug;
        $urunler->kategori_id = $request->kategori_id;
        $urunler->header_img = $data["header_img"];
        $urunler->save();

        if ($request->hasFile('images')) { 
    
            $file = $request->file('images');

            try {
                foreach ($request->file('images') as $file) { 

                    $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                    $foto_adi = str_replace("(", "", $foto_adi);
                    $foto_adi = str_replace(")", "", $foto_adi);

                    $url = $file->move(public_path('assets/img/urunler_photo'), $foto_adi);

                    $foto = new photos();  
                    $foto->content_id= $urunler->id; 
                    $foto->url = $foto_adi;
                    $foto->page = "urunler";
                    $foto->save();
                }
            } catch (Exception $e){
                Alert::success('Hata',$e->getMessage());
                return back();
            }
        }
        if($urunler){
            Alert::success('Başarılı','Ürün kaydedildi.');
            return back();
        }else{
            Alert::error('Hata','Ürün kaydedilemedi.');
            return back();
        }
    }

    function edit($id){
        $urunler=Urunler::find($id);
        $categories = Kategori::all();
        $resimler = Photos::where([
            ["content_id", $urunler->id],
            ["page", "urunler"]])->get();
        return view("panel.urunler.edit", compact("urunler", 'categories', "resimler"));
    }

    function update(Request $request, $id){;
        $urunler = Urunler::find($id);
        $data = $request->all();

        if ($request->hasFile('kapak_foto')) {

            $file = $request->file('kapak_foto');

            try{
                $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                $foto_adi = str_replace("(", "", $foto_adi);
                $foto_adi = str_replace(")", "", $foto_adi);

                $url = $file->move(public_path('assets/img/urunler_photo'), $foto_adi);

                $data["header_img"] = $foto_adi;

            }catch (Exception $e){
                return redirect()->back()->with("urunler", $e);
            }
        }

        $urunler->title = $request->title;
        $urunler->contents = $request->contents;
        $urunler->price = $request->price;
        $urunler->slug = $request->slug;
            if (isset($data["header_img"])) {
                $urunler->header_img = $data["header_img"];
            }
        $urunler->save();

        if ($request->hasFile('images')) {

            $file = $request->file('images');

            try {
                foreach ($request->file('images') as $file) {

                    $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                    $foto_adi = str_replace("(", "", $foto_adi);
                    $foto_adi = str_replace(")", "", $foto_adi);

                    $url = $file->move(public_path('assets/img/urunler_photo'), $foto_adi);

                    $foto = new photos();
                    $foto->content_id= $urunler->id;
                    $foto->url = $foto_adi;
                    $foto->page = "urunler";
                    $foto->save();
                }
            } catch (Exception $e){
                Alert::success('Hata',$e->getMessage());
                return back();
            }
        }
        if($urunler){
            Alert::success('Başarılı','Güncelleme kaydedildi.');
            return back();
        }else{
            Alert::error('Hata','Güncelleme kaydedilemedi.');
            return back();
        }
    }

    function delete($id){
        $urunler = Urunler::find($id);

        if($urunler->delete()){
            Alert::success('Başarılı','Ürün Silindi')->toast();
            return back();
        }else {
            Alert::error('Hata','Ürün Silinemedi.');
            return back();
        }
    }
}
