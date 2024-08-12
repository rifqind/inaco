<?php

use App\Http\Controllers\Cms\AuthenticatedSessionController;
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

Route::get('/webappcms/login', function () {
    return view('cms.login');
});

Route::middleware('guest')->group(function () {
    Route::get('webappcms/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('webappcms/login', [AuthenticatedSessionController::class, 'store']);
});
//menu
Route::middleware('auth')->group(function () {
    Route::get('/webappcms', function () {
        return view('cms.dashboard');
    })->name('home.webappcms');
    Route::post('webappcms/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
    Route::get('/webappcms/menu', [MenuController::class, 'index'])->name('menu.list');
    Route::get('/webappcms/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/webappcms/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/webappcms/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::post('/webappcms/menu/update', [MenuController::class, 'update']);
    Route::delete('/webappcms/menu/destroy/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    //official social media - marketplace
    Route::get('/webappcms/social-media', [SocmedmarketController::class, 'index'])->name('social-media.list');

    Route::get('/webappcms/marketplace', [SocmedmarketController::class, 'index'])->name('marketplace.list');

    Route::get('/webappcms/socmed-marketplace/create', [SocmedmarketController::class, 'create'])->name('socmed-marketplace.create');
    Route::get('/webappcms/socmed-marketplace/update/{id}', [SocmedmarketController::class, 'update'])->name('socmed-marketplace.update');
    Route::post('/webappcms/socmed-marketplace/update', [SocmedmarketController::class, 'update']);
    Route::post('/webappcms/socmed-marketplace/store', [SocmedmarketController::class, 'store'])->name('socmed-marketplace.store');
    Route::delete('/webappcms/socmed-marketplace/destroy/{id}', [SocmedmarketController::class, 'destroy'])->name('socmed-marketplace.destroy');

    //pages
    Route::get('/webappcms/pages', [PageController::class, 'index'])->name('pages.list');
    Route::get('/webappcms/pages/create', [PageController::class, 'create'])->name('pages.create');
    Route::post('/webappcms/pages/store', [PageController::class, 'store'])->name('pages.store');
    Route::get('/webappcms/pages/update/{id}', [PageController::class, 'update'])->name('pages.update');
    Route::post('/webappcms/pages/update', [PageController::class, 'update']);
    Route::delete('/webappcms/pages/destroy/{id}', [PageController::class, 'destroy'])->name('pages.destroy');

    //subpages
    Route::get('/webappcms/subpages', [SubpageController::class, 'index'])->name('subpages.list');
    Route::get('/webappcms/subpages/create', [SubpageController::class, 'create'])->name('subpages.create');
    Route::post('/webappcms/subpages/store', [SubpageController::class, 'store'])->name('subpages.store');
    Route::get('/webappcms/subpages/update/{id}', [SubpageController::class, 'update'])->name('subpages.update');
    Route::post('/webappcms/subpages/update', [SubpageController::class, 'update']);
    Route::delete('/webappcms/subpages/destroy/{id}', [SubpageController::class, 'destroy'])->name('subpages.destroy');

    //language
    Route::get('/webappcms/language', [LanguageController::class, 'index'])->name('language.list');
    Route::get('/webappcms/language/create', [LanguageController::class, 'create'])->name('language.create');
    Route::post('/webappcms/language/store', [LanguageController::class, 'store'])->name('language.store');
    Route::get('/webappcms/language/update/{id}', [LanguageController::class, 'update'])->name('language.update');
    Route::post('/webappcms/language/update', [LanguageController::class, 'update']);
    Route::delete('/webappcms/language/destroy/{id}', [LanguageController::class, 'destroy'])->name('language.destroy');

    //news
    Route::get('/webappcms/news', [NewsController::class, 'index'])->name('news.list');
    Route::get('/webappcms/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/webappcms/news/store', [NewsController::class, 'store'])->name('news.store');
    Route::get('/webappcms/news/update/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::post('/webappcms/news/update', [NewsController::class, 'update']);
    Route::delete('/webappcms/news/destroy/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

    //recipe
    Route::get('/webappcms/recipes', [RecipeController::class, 'index'])->name('recipes.list');
    Route::get('/webappcms/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/webappcms/recipes/store', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/webappcms/recipes/update/{id}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::post('/webappcms/recipes/update', [RecipeController::class, 'update']);
    Route::delete('/webappcms/recipes/destroy/{id}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

    //products
    Route::get('/webappcms/products', [ProductController::class, 'index'])->name('products.list');
    Route::get('/webappcms/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/webappcms/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/webappcms/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::post('/webappcms/products/update', [ProductController::class, 'update']);
    Route::delete('/webappcms/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    //product-category
    Route::get('/webappcms/products-category', [ProductcategoryController::class, 'index'])->name('products-category.list');
    Route::get('/webappcms/products-category/create', [ProductcategoryController::class, 'create'])->name('products-category.create');
    Route::post('/webappcms/products-category/store', [ProductcategoryController::class, 'store'])->name('products-category.store');
    Route::get('/webappcms/products-category/update/{id}', [ProductcategoryController::class, 'update'])->name('products-category.update');
    Route::post('/webappcms/products-category/update', [ProductcategoryController::class, 'update']);
    Route::delete('/webappcms/products-category/destroy/{id}', [ProductcategoryController::class, 'destroy'])->name('products-category.destroy');
});
