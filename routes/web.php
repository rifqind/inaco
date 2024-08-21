<?php

use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('web.home');
Route::get('/recipe', [HomeController::class, 'recipe'])->name('web.recipe');
Route::get('/catalog/{id}/{code?}', [HomeController::class, 'catalog'])->name('web.catalog');
Route::get('/news/{id}/{code?}', [HomeController::class, 'news'])->name('web.news');
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
require __DIR__ . '/cms.php';
