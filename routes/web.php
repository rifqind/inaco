<?php

use App\Http\Controllers\Cms\LanguageController;
use App\Http\Controllers\Cms\MenuController;
use App\Http\Controllers\Cms\NewsController;
use App\Http\Controllers\Cms\PageController;
use App\Http\Controllers\Cms\ProductcategoryController;
use App\Http\Controllers\Cms\ProductController;
use App\Http\Controllers\Cms\RecipeController;
use App\Http\Controllers\Cms\SocmedmarketController;
use App\Http\Controllers\Cms\SubpageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('cms.dashboard');
});
Route::get('/login', function () {
    return view('cms.login');
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

//news
Route::get('/news', [NewsController::class, 'index'])->name('news.list');
Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
Route::get('/news/update/{id}', [NewsController::class, 'update'])->name('news.update');
Route::post('/news/update', [NewsController::class, 'update']);
Route::delete('/news/destroy/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

//recipe
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.list');
Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
Route::post('/recipes/store', [RecipeController::class, 'store'])->name('recipes.store');
Route::get('/recipes/update/{id}', [RecipeController::class, 'update'])->name('recipes.update');
Route::post('/recipes/update', [RecipeController::class, 'update']);
Route::delete('/recipes/destroy/{id}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

//products
Route::get('/products', [ProductController::class, 'index'])->name('products.list');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::post('/products/update', [ProductController::class, 'update']);
Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

//product-category
Route::get('/products-category', [ProductcategoryController::class, 'index'])->name('products-category.list');
Route::get('/products-category/create', [ProductcategoryController::class, 'create'])->name('products-category.create');
Route::post('/products-category/store', [ProductcategoryController::class, 'store'])->name('products-category.store');
Route::get('/products-category/update/{id}', [ProductcategoryController::class, 'update'])->name('products-category.update');
Route::post('/products-category/update', [ProductcategoryController::class, 'update']);
Route::delete('/products-category/destroy/{id}', [ProductcategoryController::class, 'destroy'])->name('products-category.destroy');