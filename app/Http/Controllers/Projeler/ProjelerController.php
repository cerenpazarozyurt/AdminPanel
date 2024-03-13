<?php

namespace App\Http\Controllers\Projeler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Projeler;
use App\Models\Photos;
use RealRashid\SweetAlert\Facades\Alert;

class ProjelerController extends Controller
{
    function index(){
        $projeler = Projeler::get();

        return view("panel.projeler.index", compact('projeler'));
    }

    public function create(Request $request){
        return view("panel.projeler.create");
    }

    public function store(Request $request){
        $data= $request -> all();

        //istekten gelen bilgileri veritabanına kaydetemek için;
        $projeler = new Projeler();
        $projeler->name = $request->name;
        $projeler->contents = $request->contents;
        $projeler->save();
        

        if ($request->hasFile('images')) { 
    
            $file = $request->file('images');

            try {
                foreach ($request->file('images') as $file) { //Eğer dosyalar yüklenmişse, her bir yüklenen dosya için bir döngü başlatılır.

                    $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                    $foto_adi = str_replace("(", "", $foto_adi);
                    $foto_adi = str_replace(")", "", $foto_adi);

                    $url = $file->move(public_path('assets/img/projeler_photo'), $foto_adi);

                    $foto = new photos();  
                    $foto->content_id= $projeler->id; 
                    $foto->url = $foto_adi;
                    $foto->page = "projeler";
                    $foto->save();
                }
            } catch (Exception $e){
                Alert::success('Hata',$e->getMessage());
                return back();
            }
        }
        if($projeler){
            Alert::success('Başarılı','Proje kaydedildi.');
            return back();
        }else{
            Alert::error('Hata','Proje kaydedilemedi.');
            return back();
        }
    }

    function edit($id){
        $projeler=Projeler::find($id);
        $resimler = Photos::where([
            ["content_id", $projeler->id],
            ["page", "projeler"]])->get();
        return view("panel.projeler.edit", compact("projeler","resimler"));
    }

    function update(Request $request, $id){
        $projeler=Projeler::find($id);
        $data = $request->all();

        $projeler->name = $request->name;
        $projeler->contents = $request->contents;
        $projeler->save();

        if ($request->hasFile('images')) {
    
            $file = $request->file('images');

            try {
                foreach ($request->file('images') as $file) {

                    $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                    $foto_adi = str_replace("(", "", $foto_adi);
                    $foto_adi = str_replace(")", "", $foto_adi);

                    $url = $file->move(public_path('assets/img/projeler_photo'), $foto_adi);

                    $foto = new projeler();
                    $foto->content_id= $projeler->id;
                    $foto->url = $foto_adi;
                    $foto->page = "projeler";
                    $foto->save();
                }
            } catch (Exception $e){
                Alert::success('Hata',$e->getMessage());
                return back();
            }
        }
        if($projeler){
            Alert::success('Başarılı','Güncelleme kaydedildi.');
            return back();
        }else{
            Alert::error('Hata','Güncelleme kaydedilemedi.');
            return back();
        }
    }

    function delete($id){
        $projeler = Projeler::find($id);

        if($projeler->delete()){
            Alert::success('Başarılı','Proje Silindi')->toast();
            return back();
        }else {
            Alert::error('Hata','Proje Silinemedi.');
            return back();
        }
    }
}
