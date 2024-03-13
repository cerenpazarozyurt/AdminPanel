<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Kategori;
use App\Models\Photos;
use RealRashid\SweetAlert\Facades\Alert;

class BlogController extends Controller
{
    function index(){
        $blog = Blog::get();  //blog modelinden tüm kayıtları çek
        $categories = Kategori::all(); // Kategorileri çek

        return view("panel.blog.index", compact('blog','categories')); //panel.blog.index adlı görünüm dosyasına "compact" fonk. ile  $blog değişkeni geçirilir
                                                                      //Bu, görünüm dosyasında $blog değişkenini kullanarak blog içeriğini görüntülemek için kullanılır.
    }
    public function create(Request $request) { //Laravel, HTTP isteklerini temsil etmek için Request sınıfını kullanır. Bu parametre, HTTP isteğiyle ilişkilendirilmiş bilgileri içerir. 
                                            //$request parametresi, HTTP isteğine erişim sağlar ve bu fonksiyonun içinde kullanılabilir.
        $categories = Kategori::all(); // Kategorileri çek
        return view("panel.blog.create" , compact('categories'));
        }

    public function store(Request $request) {

        //dd($request->all());
                $data = $request->all();

                if ($request->hasFile('kapak_foto')) {  //'kapak_foto' adında bir dosyanın var olup olmadığını kontrol eder.

                    //dosyanın geçerli bir resim dosyası olup olmadığını kontrol etmek için;
                    // $request->validate([
                    //     'kapak_foto' => 'image|mimes:jpeg,png,jpg,gif,svg',
                    // ]);
    
                    $file = $request->file('kapak_foto');
    
                    try{
                        $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName()); //dosyanın yeni adını oluşturur.
                                                                                                           //dosya adındaki boşluklar alt çizgilere dönüştürülür.
                        $foto_adi = str_replace("(", "", $foto_adi); //parantez varsa, parantezleri kaldırır.
                        $foto_adi = str_replace(")", "", $foto_adi);
    
                        $url = $file->move(public_path('assets/img/blog_photo'), $foto_adi); //Dosyayı, belirtilen hedef klasöre taşır.
    
                        $data["header_img"] = $foto_adi; //dosyanın adını,işlemin sonunda oluşturulan $data adlı dizi içinde belirtilen header_img anahtarı altına atar. 
                                                        //Bu, daha sonra bu dosyanın diğer işlemlerde kullanılabilmesi için saklanmasını sağlar.
                    }
                    catch (Exception $e){ //Eğer dosya taşıma işlemi sırasında bir hata oluşursa, Exception sınıfı kullanılarak bir istisna(exception) oluşturulur.
                        return redirect()->back()->with("blog", $e);
                    }
                }
    
                $blog = new Blog();
                $blog->title = $request->title;
                $blog->contents = $request->contents;
                $blog->slug = $request->slug;    
                $blog->kategori_id = $request->kategori_id;
                $blog->header_img = $data["header_img"];
                $blog->save();

                if ($request->hasFile('images')) { //'images' adında dosya olup olmadığını kontrol eder.
    
                    $file = $request->file('images'); //Dosyaları temsil etmek üzere 'images' adlı dosya yüklemesi alınır.
    
                    try {
                        foreach ($request->file('images') as $file) { //Eğer dosyalar yüklenmişse, her bir yüklenen dosya için bir döngü başlatılır.
     
                            $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                            $foto_adi = str_replace("(", "", $foto_adi);
                            $foto_adi = str_replace(")", "", $foto_adi);
    
                            $url = $file->move(public_path('assets/img/blog_photo'), $foto_adi);
    
                            $foto = new photos();  //Her bir dosya için yeni bir 'photos' modeli oluşturur.
                            $foto->content_id= $blog->id; //Oluşturulan 'photos' modelinin 'content_id' özelliğine, ilgili blog yazısının ID'sini atar.
                            $foto->url = $foto_adi;
                            $foto->page = "blog";
                            $foto->save();
                        }
                    }catch (Exception $e){
                        Alert::success('Hata',$e->getMessage());
                        return back();
                    }
                }

                if($blog){
                    Alert::success('Başarılı','Blog kaydedildi.');
                    return back();
                }else{
                    Alert::error('Hata','Blog kaydedilemedi.');
                    return back();
                }
    }  
    
    function edit($id){
            $blog = Blog::find($id);
            $categories = Kategori::all();
            $resimler = Photos::where([
                ["content_id", $blog->id],
                ["page", "blog"]])->get();
    
            return view("panel.blog.edit", compact("blog", 'categories', "resimler"));
        }
    
    function update(Request $request, $id){
            //dd($request,$id);
    
            $blog = Blog::find($id);
            $data = $request->all();
        
            if ($request->hasFile('kapak_foto')) {

                $file = $request->file('kapak_foto');
    
                try{
                    $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                    $foto_adi = str_replace("(", "", $foto_adi);
                    $foto_adi = str_replace(")", "", $foto_adi);
    
                    $url = $file->move(public_path('assets/img/blog_photo'), $foto_adi);
    
                    $data["header_img"] = $foto_adi;
    
                }catch (Exception $e){
                    return redirect()->back()->with("blog", $e);
                }
            }
    
            //$blog = new Blog();
            $blog->title = $request->title;
            $blog->contents = $request->contents;
            $blog->slug = $request->slug;
            $blog->kategori_id = $request->kategori_id;
            if (isset($data["header_img"])) {
                $blog->header_img = $data["header_img"];
            }
            $blog->save();
    
            if ($request->hasFile('images')) {
    
                $file = $request->file('images');
    
                try {
                    foreach ($request->file('images') as $file) {
    
                        $foto_adi = date('YmdHis') . str_replace(" ", "_", $file->getClientOriginalName());
                        $foto_adi = str_replace("(", "", $foto_adi);
                        $foto_adi = str_replace(")", "", $foto_adi);
    
                        $url = $file->move(public_path('assets/img/blog_photo'), $foto_adi);
    
                        $foto = new photos();
                        $foto->content_id= $blog->id;
                        $foto->url = $foto_adi;
                        $foto->page = "blog";
                        $foto->save();
                    }
                } catch (Exception $e){
                    Alert::success('Hata',$e->getMessage());
                    return back();
                }
    
            }
            if($blog){
                Alert::success('Başarılı','Güncelleme kaydedildi.');
                return back();
            }else{
                Alert::error('Hata','Güncelleme kaydedilemedi.');
                return back();
            }
        }
    
        function delete($id){
            $blog = Blog::find($id);
    
            if($blog->delete()){
                Alert::success('Başarılı','Blog Silindi')->toast();
                return back();
            }else {
                Alert::error('Hata','Blog Silinemedi.');
                return back();
            }
        }
}
    
    
