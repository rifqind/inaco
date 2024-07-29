<?php

use App\Http\Controllers\Cms\MenuController;
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
