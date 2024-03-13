<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\Urunler\UrunlerController;
use App\Http\Controllers\Referanslar\ReferanslarController;
use App\Http\Controllers\Projeler\ProjelerController;
use App\Http\Controllers\Kategori\KategoriController;
use App\Http\Controllers\Delete\DeleteController;
use App\Http\Controllers\Dashboard\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('panel/blog-list', [BlogController::class, 'index']) ->name('blog.index'); //GET isteği ile 'panel/blog-list' yolunu işleyen bir rotayı tanımlar. Bu rotaya gelen istekler, BlogController denetleyicisinin index yöntemine yönlendirilir.
//Route::get('panel/blog', [BlogController::class, 'blog']) ->name('panel.blog'); 
Route::get('panel/blog/create', [BlogController::class, 'create']) ->name('panel.blog.create');
Route::post('panel/blog/store', [BlogController::class, 'store']) ->name('panel.blog.store');
Route::get('panel/blog/edit/{id}', [BlogController::class, 'edit']) ->name('panel.blog.edit');
Route::post('panel/blog/update/{id}', [BlogController::class, 'update']) ->name('panel.blog.update');
Route::get('panel/blog/delete/{id}', [BlogController::class, 'delete']) ->name('panel.blog.delete');


Route::get('panel/news-list', [NewsController::class, 'index']) ->name('news.index');
Route::get('panel/news/create', [NewsController::class, 'create']) ->name('panel.news.create');
Route::post('panel/news/store', [NewsController::class, 'store']) ->name('panel.news.store');
Route::get('panel/news/edit/{id}', [NewsController::class, 'edit']) ->name('panel.news.edit');
Route::post('panel/news/update/{id}', [NewsController::class, 'update']) ->name('panel.news.update');
Route::get('panel/news/delete/{id}', [NewsController::class, 'delete']) ->name('panel.news.delete');

Route::get('panel/delete/photo/{page}/{id}', [DeleteController::class, 'delete'])->name('deleteNewsImage');


Route::get('panel/urunler-list', [UrunlerController::class, 'index']) ->name('urunler.index');
Route::get('panel/urunler/create', [UrunlerController::class, 'create']) ->name('panel.urunler.create');
Route::post('panel/urunler/store', [UrunlerController::class, 'store']) ->name('panel.urunler.store');
Route::get('panel/urunler/edit/{id}', [UrunlerController::class, 'edit']) ->name('panel.urunler.edit');
Route::post('panel/urunler/update/{id}', [UrunlerController::class, 'update']) ->name('panel.urunler.update');
Route::get('panel/urunler/delete/{id}', [UrunlerController::class, 'delete']) ->name('panel.urunler.delete');


Route::get('panel/referanslar-list', [ReferanslarController::class, 'index']) ->name('referanslar.index');
Route::get('panel/referanslar/create', [ReferanslarController::class, 'create']) ->name('panel.referanslar.create');
Route::post('panel/referanslar/store', [ReferanslarController::class, 'store']) ->name('panel.referanslar.store');
Route::get('panel/referanslar/edit/{id}', [ReferanslarController::class, 'edit']) ->name('panel.referanslar.edit');
Route::post('panel/referanslar/update/{id}', [ReferanslarController::class, 'update']) ->name('panel.referanslar.update');
Route::get('panel/referanslar/delete/{id}', [ReferanslarController::class, 'delete']) ->name('panel.referanslar.delete');


Route::get('panel/projeler-list', [ProjelerController::class, 'index']) ->name('projeler.index');
Route::get('panel/projeler/create', [ProjelerController::class, 'create']) ->name('panel.projeler.create');
Route::post('panel/projeler/store', [ProjelerController::class, 'store']) ->name('panel.projeler.store');
Route::get('panel/projeler/edit/{id}', [ProjelerController::class, 'edit']) ->name('panel.projeler.edit');
Route::post('panel/projeler/update/{id}', [ProjelerController::class, 'update']) ->name('panel.projeler.update');
Route::get('panel/projeler/delete/{id}', [ProjelerController::class, 'delete']) ->name('panel.projeler.delete');


Route::get('panel/categories-list', [KategoriController::class, 'index'])->name('categories.index');
Route::get('panel/categories/create', [KategoriController::class, 'create']) ->name('panel.categories.create');
Route::post('panel/categories/store', [KategoriController::class, 'store']) ->name('panel.categories.store');
Route::get('panel/categories/edit/{id}', [KategoriController::class, 'edit']) ->name('panel.categories.edit');
Route::post('panel/categories/update/{id}', [KategoriController::class, 'update']) ->name('panel.categories.update');
//Route::get('panel/categories/{id}', [KategoriController::class, 'show'])->name('categories.show');
Route::get('panel/categories/delete/{id}', [KategoriController::class, 'delete']) ->name('panel.categories.delete');




require __DIR__.'/auth.php';

