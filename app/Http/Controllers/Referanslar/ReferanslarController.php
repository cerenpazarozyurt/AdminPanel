<?php

namespace App\Http\Controllers\Referanslar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Referanslar;
use RealRashid\SweetAlert\Facades\Alert;

class ReferanslarController extends Controller
{
    function index(){
        $referanslar = Referanslar::get();

        return view("panel.referanslar.index", compact('referanslar'));
    }

    public function create(Request $request){
        return view("panel.referanslar.create");
    }

    public function store(Request $request){
        $data= $request -> all();

        //istekten gelen bilgileri veritabanına kaydetemek için;
        $referanslar = new Referanslar();
        $referanslar->name = $request->name;
        $referanslar->email = $request->email;
        $referanslar->save();

        if($referanslar){
            Alert::success('Başarılı','Referans kaydedildi.');
            return back();
        }else {
            Alert::error('Hata','Referans kaydedilemedi.');
            return back();
        }
    }

    function edit($id){
        $referanslar=Referanslar::find($id);
        return view("panel.referanslar.edit", compact("referanslar"));
    }

    function update(Request $request, $id){;
        $referanslar = Referanslar::find($id);
        $data = $request->all();

        $referanslar->name = $request->name;
        $referanslar->email = $request->email;
        $referanslar->save();

        if($referanslar){
            Alert::success('Başarılı','Güncelleme kaydedildi.');
            return back();
        }else {
            Alert::error('Hata','Güncelleme kaydedilemedi.');
            return back();
        }
       
    }

    function delete($id){
        $referanslar = Referanslar::find($id);

        if($referanslar->delete()){
            Alert::success('Başarılı',' Referans silindi.')->toast();
            return back();
        }else {
            Alert::error('Hata','Referans silinemedi.');
            return back();
        }
    }
}
