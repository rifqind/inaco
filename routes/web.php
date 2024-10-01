<?php

use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/cms.php';

Route::name('web.id.')->group(function () {
    Route::get('/katalog/{id}/{category_title?}/{product?}', [HomeController::class, 'katalog'])->name('katalog');
    Route::get('/penghargaan', [HomeController::class, 'pages'])->name('penghargaan');
    Route::get('/tentang-kami', [HomeController::class, 'pages'])->name('tentang');
    Route::get('/temukan-kami', [HomeController::class, 'pages'])->name('temukan-kami');
    Route::get('/karir', [HomeController::class, 'pages'])->name('karir');
    Route::get('/tur-pabrik', [HomeController::class, 'pages'])->name('tur-pabrik');
    Route::get('/profil-perusahaan', [HomeController::class, 'pages'])->name('profil-perusahaan');
    Route::get('/produk/{category_title?}/{product?}', [HomeController::class, 'produk'])->name('produk');
    Route::get('/distributor', [HomeController::class, 'distributorIndonesia'])->name('distributor');
    Route::get('/pasar-internasional', [HomeController::class, 'intermarketInd'])->name('intermarket');
    Route::get('/resep/{title?}', [HomeController::class, 'resep'])->name('resep');
    Route::get('/berita/{id}/{title?}', [HomeController::class, 'berita'])->name('berita');
});
Route::prefix('{code?}')
    // ->where(['code'], '[a-zA-Z]{2}')
    ->name('web.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/recipe/{title?}', [HomeController::class, 'recipe'])->name('recipe');
        Route::get('/catalog/{id}', [HomeController::class, 'catalog'])->name('catalog');
        Route::get('/news/{id}/{title?}', [HomeController::class, 'news'])->name('news');
        Route::get('/about', function (String $code = null) {
            $code ??= 'id';
            if ($code == 'id') return redirect()->route('web.id.tentang');
        })->name('about');
        Route::get('/awards', function (String $code = null) {
            $code ??= 'id';
            if ($code == 'id') return redirect()->route('web.id.penghargaan');
        })->name('awards');
        Route::get('/find-us', function (String $code = null) {
            $code ??= 'id';
            if ($code == 'id') return redirect()->route('web.id.temukan-kami');
        })->name('find-us');
        Route::get('/careers', function (String $code = null) {
            $code ??= 'id';
            if ($code == 'id') return redirect()->route('web.id.karir');
        })->name('careers');
        Route::get('/factory-tour', function (String $code = null) {
            $code ??= 'id';
            if ($code == 'id') return redirect()->route('web.id.tur-pabrik');
        })->name('factory-tour');
        Route::get('/company-profile', function (String $code = null) {
            $code ??= 'id';
            if ($code == 'id') return redirect()->route('web.id.profil-perusahaan');
        })->name('company-profile');
        Route::get('/distributor', [HomeController::class, 'distributor'])->name('distributor');
        Route::get('/products/{category_title?}/{product?}', [HomeController::class, 'products'])->name('products');
        Route::get('/international-market', [HomeController::class, 'intermarket'])->name('intermarket');
    });
Route::post('/web-question', [HomeController::class, 'question'])->name('question');
Route::get('/fetch/province/{id}', function (String $id) {
    $target = DB::table('ref_province')->where('country_id', $id)
        ->get([
            'code as value',
            'name as label'
        ]);
    return response()->json($target);
});
Route::get('/fetch/city/{id}', function (String $id) {
    $target = DB::table('ref_city')->where('province_id', $id)
        ->get([
            'id as value',
            'code',
            'name as label'
        ]);
    return response()->json($target);
});
Route::get('/fetch/district/{id}', function (String $id) {
    $target = DB::table('ref_district')->where('city_id', $id)
        ->get([
            'code as value',
            'name as label'
        ]);
    return response()->json($target);
});
Route::get('/fetch/subdistrict/{id}', function (String $id) {
    $target = DB::table('ref_subdistrict')->where('district', $id)
        ->get([
            'code as value',
            'name as label'
        ]);
    return response()->json($target);
});
