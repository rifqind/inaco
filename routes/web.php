<?php

use App\Http\Controllers\Cms\LanguageController;
use App\Http\Controllers\Cms\MenuController;
use App\Http\Controllers\Cms\PageController;
use App\Http\Controllers\Cms\SocmedmarketController;
use App\Http\Controllers\Cms\SubpageController;
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

//pages
Route::get('/pages', [PageController::class, 'index'])->name('pages.list');
Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
Route::post('/pages/store', [PageController::class, 'store'])->name('pages.store');
Route::get('/pages/update/{id}', [PageController::class, 'update'])->name('pages.update');
Route::post('/pages/update', [PageController::class, 'update']);
Route::delete('/pages/destroy/{id}', [PageController::class, 'destroy'])->name('pages.destroy');

//subpages
Route::get('/subpages', [SubpageController::class, 'index'])->name('subpages.list');
Route::get('/subpages/create', [SubpageController::class, 'create'])->name('subpages.create');
Route::post('/subpages/store', [SubpageController::class, 'store'])->name('subpages.store');
Route::get('/subpages/update/{id}', [SubpageController::class, 'update'])->name('subpages.update');
Route::post('/subpages/update', [SubpageController::class, 'update']);
Route::delete('/subpages/destroy/{id}', [SubpageController::class, 'destroy'])->name('subpages.destroy');

//language
Route::get('/language', [LanguageController::class, 'index'])->name('language.list');
Route::get('/language/create', [LanguageController::class, 'create'])->name('language.create');
Route::post('/language/store', [LanguageController::class, 'store'])->name('language.store');
Route::get('/language/update/{id}', [LanguageController::class, 'update'])->name('language.update');
Route::post('/language/update', [LanguageController::class, 'update']);
Route::delete('/language/destroy/{id}', [LanguageController::class, 'destroy'])->name('language.destroy');