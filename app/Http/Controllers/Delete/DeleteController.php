<?php

namespace App\Http\Controllers\Delete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\News;
use App\Models\Projeler;
use App\Models\Urunler;
use App\Models\Photos;
use RealRashid\SweetAlert\Facades\Alert;


class DeleteController extends Controller
{
    public function delete($page, $photoId)
    {
        $foto = Photos::find($photoId);

        if (!$foto) {
            return redirect()->back()->with("message", "Fotoğraf bulunamadı.");
        }

        $klasor = $this->getKlasor($page);
        $fotoYolu = $this->getFotoYolu($klasor, $foto->url);

        if (file_exists($fotoYolu)) {
            unlink($fotoYolu);
        }

        if($foto->delete()){
            Alert::success('Başarılı','Fotoğraf silme işlemi başarılı.')->toast();
            return back();
        }else {
            Alert::error('Hata','Fotoğraf silme işlemi başarısız.');
            return back();
        }
    }

    private function getKlasor($page)
    {
        switch ($page) {
            case 'news':
                return 'news_photo';
            case 'blog':
                return 'blog_photo';
            case 'projeler':
                return 'projeler_photo';
            case 'urunler':
                return 'urunler_photo';
            default:
                return ''; 
        }
    }

    private function getFotoYolu($klasor, $fotoUrl)
    {
        $temelYol = public_path("assets/img/{$klasor}");
        return "{$temelYol}/{$fotoUrl}";
    }
}
