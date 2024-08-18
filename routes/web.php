<?php

use App\Http\Cms\Controllers\HomebannerController;
use App\Http\Cms\Controllers\IntermarketController;
use App\Http\Controllers\Cms\AuthenticatedSessionController;
use App\Http\Controllers\Cms\DistributorController;
use App\Http\Controllers\Cms\LanguageController;
use App\Http\Controllers\Cms\MenuController;
use App\Http\Controllers\Cms\NewsController;
use App\Http\Controllers\Cms\PageController;
use App\Http\Controllers\Cms\ProductcategoryController;
use App\Http\Controllers\Cms\ProductController;
use App\Http\Controllers\Cms\RecipeController;
use App\Http\Controllers\Cms\SocmedmarketController;
use App\Http\Controllers\Cms\SubpageController;
use App\Http\Controllers\Cms\UserController;
use Illuminate\Support\Facades\DB;
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
});
Route::prefix('webappcms')->middleware(['auth', 'permission:Settings'])->name('user.')->group(function () {
    //user, role and permission
    Route::get('/user', [UserController::class, 'index'])->name('list');
    Route::get('/roles', [UserController::class, 'roleIndex'])->name('role.list');
    Route::get('/permissions', [UserController::class, 'permissionIndex'])->name('permission.list');
    Route::get('/user/create', [UserController::class, 'create'])->name('create');
    Route::post('/user/create', [UserController::class, 'create']);
    Route::get('/role/create', [UserController::class, 'roleCreate'])->name('role.create');
    Route::post('/role/create', [UserController::class, 'roleCreate']);
    Route::get('/permissions/create', [UserController::class, 'permissionCreate'])->name('permission.create');
    Route::post('/permissions/create', [UserController::class, 'permissionCreate']);
    Route::post('/user/store', [UserController::class, 'store'])->name('store');
    Route::get('/user/update/{id}', [UserController::class, 'update'])->name('update');
    Route::post('/user/update', [UserController::class, 'update']);
    Route::get('/role/update/{id}', [UserController::class, 'updateRole'])->name('role.update');
    Route::post('/role/update', [UserController::class, 'updateRole']);
    Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::delete('/permission/destroy/{id}', [UserController::class, 'permissionDestroy'])->name('permission.destroy');
    Route::delete('/role/destroy/{id}', [UserController::class, 'roleDestroy'])->name('role.destroy');
});

Route::prefix('webappcms')->middleware(['auth', 'permission:Settings'])->name('menu.')->group(function () {
    //menu
    Route::get('/menu', [MenuController::class, 'index'])->name('list');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('create');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('store');
    Route::get('/menu/update/{id}', [MenuController::class, 'update'])->name('update');
    Route::post('/menu/update', [MenuController::class, 'update']);
    Route::delete('/menu/destroy/{id}', [MenuController::class, 'destroy'])->name('destroy');
});

Route::prefix('webappcms')->middleware(['auth', 'permission:Settings'])->name('socmed-marketplace.')->group(function () {
    //official social media - marketplace
    Route::get('/social-media', [SocmedmarketController::class, 'index'])->name('social-media.list');
    Route::get('/marketplace', [SocmedmarketController::class, 'index'])->name('marketplace.list');

    Route::get('/socmed-marketplace/create', [SocmedmarketController::class, 'create'])->name('create');
    Route::get('/socmed-marketplace/update/{id}', [SocmedmarketController::class, 'update'])->name('update');
    Route::post('/socmed-marketplace/update', [SocmedmarketController::class, 'update']);
    Route::post('/socmed-marketplace/store', [SocmedmarketController::class, 'store']);
    Route::delete('/socmed-marketplace/destroy/{id}', [SocmedmarketController::class, 'destroy'])->name('destroy');
});


Route::prefix('webappcms')->middleware(['auth', 'permission:Settings'])->name('pages.')->group(function () {
    //pages
    Route::get('/pages', [PageController::class, 'index'])->name('list');
    Route::get('/pages/create', [PageController::class, 'create'])->name('create');
    Route::post('/pages/store', [PageController::class, 'store'])->name('store');
    Route::get('/pages/update/{id}', [PageController::class, 'update'])->name('update');
    Route::post('/pages/update', [PageController::class, 'update']);
    Route::delete('/pages/destroy/{id}', [PageController::class, 'destroy'])->name('destroy');
});


Route::prefix('webappcms')->middleware(['auth', 'permission:Settings'])->name('subpages.')->group(function () {
    //subpages
    Route::get('/subpages', [SubpageController::class, 'index'])->name('list');
    Route::get('/subpages/create', [SubpageController::class, 'create'])->name('create');
    Route::post('/subpages/store', [SubpageController::class, 'store'])->name('store');
    Route::get('/subpages/update/{id}', [SubpageController::class, 'update'])->name('update');
    Route::post('/subpages/update', [SubpageController::class, 'update']);
    Route::delete('/subpages/destroy/{id}', [SubpageController::class, 'destroy'])->name('destroy');
});


Route::prefix('webappcms')->middleware(['auth', 'permission:Settings'])->name('language.')->group(function () {
    //language
    Route::get('/language', [LanguageController::class, 'index'])->name('list');
    Route::get('/language/create', [LanguageController::class, 'create'])->name('create');
    Route::post('/language/store', [LanguageController::class, 'store'])->name('store');
    Route::get('/language/update/{id}', [LanguageController::class, 'update'])->name('update');
    Route::post('/language/update', [LanguageController::class, 'update']);
    Route::delete('/language/destroy/{id}', [LanguageController::class, 'destroy'])->name('destroy');
});

Route::prefix('webappcms')->middleware(['auth', 'permission:News'])->name('news.')->group(function () {
    //news
    Route::get('/news', [NewsController::class, 'index'])->name('list');
    Route::get('/news/create', [NewsController::class, 'create'])->name('create');
    Route::post('/news/store', [NewsController::class, 'store'])->name('store');
    Route::get('/news/update/{id}', [NewsController::class, 'update'])->name('update');
    Route::post('/news/update', [NewsController::class, 'update']);
    Route::delete('/news/destroy/{id}', [NewsController::class, 'destroy'])->name('destroy');
});

Route::prefix('webappcms')->middleware(['auth', 'permission:Recipe'])->name('recipes.')->group(function () {
    //recipe
    Route::get('/recipes', [RecipeController::class, 'index'])->name('list');
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('create');
    Route::post('/recipes/store', [RecipeController::class, 'store'])->name('store');
    Route::get('/recipes/update/{id}', [RecipeController::class, 'update'])->name('update');
    Route::post('/recipes/update', [RecipeController::class, 'update']);
    Route::delete('/recipes/destroy/{id}', [RecipeController::class, 'destroy'])->name('destroy');
});

Route::prefix('webappcms')->middleware(['auth', 'permission:Products'])->name('products.')->group(function () {
    //products
    Route::get('/products', [ProductController::class, 'index'])->name('list');
    Route::get('/products/create', [ProductController::class, 'create'])->name('create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('store');
    Route::get('/products/update/{id}', [ProductController::class, 'update'])->name('update');
    Route::post('/products/update', [ProductController::class, 'update']);
    Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
});

Route::prefix('webappcms')->middleware(['auth', 'permission:Products'])->name('products-category.')->group(function () {
    //product-category
    Route::get('/products-category', [ProductcategoryController::class, 'index'])->name('list');
    Route::get('/products-category/create', [ProductcategoryController::class, 'create'])->name('create');
    Route::post('/products-category/store', [ProductcategoryController::class, 'store'])->name('store');
    Route::get('/products-category/update/{id}', [ProductcategoryController::class, 'update'])->name('update');
    Route::post('/products-category/update', [ProductcategoryController::class, 'update']);
    Route::delete('/products-category/destroy/{id}', [ProductcategoryController::class, 'destroy'])->name('destroy');
});

Route::prefix('webappcms')->middleware(['auth', 'permission:Distributors'])->name('distributor.')->group(function () {
    //distributors
    Route::get('/distributor', [DistributorController::class, 'index'])->name('list');
    Route::get('/distributor/create', [DistributorController::class, 'create'])->name('create');
    Route::post('/distributor/store', [DistributorController::class, 'store'])->name('store');
    Route::get('/distributor/update/{id}', [DistributorController::class, 'update'])->name('update');
    Route::post('/distributor/update', [DistributorController::class, 'update']);
    Route::delete('/distributor/destroy/{id}', [DistributorController::class, 'destroy'])->name('destroy');
});

Route::prefix('webappcms')->middleware(['auth', 'permission:Home - Banner'])->name('banner.')->group(function () {
    //homebanner
    Route::get('/banner', [HomebannerController::class, 'index'])->name('list');
    Route::get('/banner/create', [HomebannerController::class, 'create'])->name('create');
    Route::post('/banner/store', [HomebannerController::class, 'store'])->name('store');
    Route::get('/banner/update/{id}', [HomebannerController::class, 'update'])->name('update');
    Route::post('/banner/update', [HomebannerController::class, 'update']);
    Route::delete('/banner/destroy/{id}', [HomebannerController::class, 'destroy'])->name('destroy');
});

Route::prefix('webappcms')->middleware(['auth', 'permission:International Market'])->name('inter-market.')->group(function () {
    //intermarket
    Route::get('/inter-market', [IntermarketController::class, 'index'])->name('list');
    Route::get('/inter-market/create', [IntermarketController::class, 'create'])->name('create');
    Route::post('/inter-market/store', [IntermarketController::class, 'store'])->name('store');
    Route::get('/inter-market/update/{id}', [IntermarketController::class, 'update'])->name('update');
    Route::post('/inter-market/update', [IntermarketController::class, 'update']);
    Route::delete('/inter-market/destroy/{id}', [IntermarketController::class, 'destroy'])->name('destroy');
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
