<?php

use App\Http\Controllers\Cms\MenuController;
use App\Http\Controllers\Cms\SocmedmarketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('cms.dashboard');
});

//menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu.list');
Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
Route::get('/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
Route::post('/menu/update', [MenuController::class, 'update']);
Route::delete('/menu/destroy/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

//official social media - marketplace
Route::get('/social-media', [SocmedmarketController::class, 'index'])->name('social-media.list');

Route::get('/marketplace', [SocmedmarketController::class, 'index'])->name('marketplace.list');

Route::get('/socmed-marketplace/create', [SocmedmarketController::class, 'create'])->name('socmed-marketplace.create');
Route::get('/socmed-marketplace/update/{id}', [SocmedmarketController::class, 'update'])->name('socmed-marketplace.update');
Route::post('/socmed-marketplace/update', [SocmedmarketController::class, 'update']);
Route::post('/socmed-marketplace/store', [SocmedmarketController::class, 'store'])->name('socmed-marketplace.store');
Route::delete('/socmed-marketplace/destroy/{id}', [SocmedmarketController::class, 'destroy'])->name('socmed-marketplace.destroy');