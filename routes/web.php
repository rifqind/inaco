<?php

use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/cms.php';

Route::prefix('{code?}')
    // ->where(['code'], '[a-zA-Z]{2}')
    ->name('web.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/recipe', [HomeController::class, 'recipe'])->name('recipe');
        Route::get('/catalog/{id}/{category_title?}', [HomeController::class, 'catalog'])->name('catalog');
        Route::get('/news/{id}', [HomeController::class, 'news'])->name('news');
        Route::get('/about', [HomeController::class, 'pages'])->name('about');
        Route::get('/distributor', [HomeController::class, 'distributor'])->name('distributor');
        Route::get('/international-market', [HomeController::class, 'intermarket'])->name('intermarket');
    });



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
