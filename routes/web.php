<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\RecipeController;
use App\Http\Controllers\Web\DistributorController;
use App\Http\Controllers\Web\NewsController;
use App\Models\NewsTranslation;
use App\Models\OfficialSocmedMarketplace;
use App\Models\PageTranslation;
use App\Models\ProductCategoryTranslation;
use App\Models\ProductTranslation;
use App\Models\RecipeTranslation;
use App\Models\SubpageTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/cms.php';

Route::name('web.id.')->group(function () {
    Route::get('/katalog/{id}/{category_title?}/{product?}', [ProductController::class, 'katalog'])->name('katalog');
    Route::get('/penghargaan', [PageController::class, 'index'])->name('penghargaan');
    Route::get('/temukan-kami', [PageController::class, 'index'])->name('temukan-kami');
    Route::get('/karir', [PageController::class, 'index'])->name('karir');
    Route::get('/tur-pabrik', [PageController::class, 'index'])->name('tur-pabrik');
    Route::get('/profil-perusahaan', [PageController::class, 'index'])->name('profil-perusahaan');
    Route::get('/visi-misi', [PageController::class, 'index'])->name('visi-misi');
    Route::get('/produk/{category_title?}/{product?}', [ProductController::class, 'index'])->name('produk');
    Route::get('/distributor', [DistributorController::class, 'index'])->name('distributor');
    Route::get('/pasar-internasional', [DistributorController::class, 'intermarketInd'])->name('intermarket');
    Route::get('/resep/{title?}', [RecipeController::class, 'index'])->name('resep');
    Route::get('/resep/kategori/{cat_title?}', [RecipeController::class, 'index'])->name('resep.kategori');
    Route::get('/resep/detail/{title?}', [RecipeController::class, 'resepDetail'])->name('resep.detail');
    Route::get('/berita/{id}/{title?}', [NewsController::class, 'index'])->name('berita');
    Route::get('/view/{id}', [PageController::class, 'view'])->name('view');
});


Route::prefix('{code?}')
    // ->where(['code'], '[a-zA-Z]{2}')
    ->name('web.')->group(function () { 
  //      Route::get('/view/{id}', [PageController::class, 'view'])->name('view');
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/recipe/{title?}', [RecipeController::class, 'recipe'])->name('recipe');
        Route::get('/recipe/category/{cat_title?}', [RecipeController::class, 'recipe'])->name('recipe.category');
        Route::get('/recipe/detail/{title?}', [RecipeController::class, 'recipeDetail'])->name('recipe.detail');
        Route::get('/catalog/{id}', [ProductController::class, 'catalog'])->name('catalog');
        Route::get('/news/{id}/{title?}', [NewsController::class, 'news'])->name('news');
        Route::get('/company-profile', function (string $code = null) {
            $code ??= 'id';
            if ($code == 'id')
                return redirect()->route('web.id.profil-perusahaan');

            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('sb.pages_id', 5)    // Content Profil Perusahaan
                ->where('pages_status', 1)
                ->first();

            // Fetch tentang description
            if ($page) {
                $header_description = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_id', 5)                  // Header Profile Perusahaan / About
                    ->where('sb.sub_pages_status', 1)
                    ->first();
            //    print_r($header_description->sub_pages_translation_id);    

            }
            // Fetch list of other years (excluding 'tentang-inaco')
            $tentang_list_tahun = collect();  // Initialize empty collection
            if ($page) {
                $tentang_list_tahun = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->where('sb.sub_pages_id','<>', 5)   // Not header
                    ->orderBy('sub_pages_title')
                    ->get();
            }
            // Sanitize the page description, if it exists
            // if ($page) {
            //     $page->pages_description = strip_tags(html_entity_decode($page->pages_description));
            // }
            return view('web.about', [
                'page' => $page,
                'code' => $code,
                'descriptions' => $header_description ??= null,
                'list_year' => $tentang_list_tahun ??= collect([]),
            ]);
        })->name('about');
        Route::get('/awards', function (string $code = null) {
            $code ??= 'id';
            if ($code == 'id')
                return redirect()->route('web.id.penghargaan');
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('sb.pages_id', 6)    // Content Penghargaan
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $header_description = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_id', 21)    // Header Penghargaan
                    ->where('sb.sub_pages_status', 1)
                    ->first();
                $award_list = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('pages_id', $page->pages_id)
                    ->where('sb.sub_pages_id', '<>', 21)  // Not Header
                    ->where('sb.sub_pages_status', 1)
                    ->get();
                $award_list = $award_list->map(function ($item) {
                    // Convert sub_pages_description to an integer
                    $item->sub_pages_description = (int) strip_tags(html_entity_decode($item->sub_pages_description));
                    return $item;
                })->sortByDesc('sub_pages_description');
            }

            return view('web.awards', [
                'page' => $page,
                'code' => $code,
                'descriptions' => $header_description ??= null,
                'award_list' => $award_list ??= collect([]),
            ]);
        })->name('awards');
        Route::get('/find-us', function (string $code = null) {
            $code ??= 'id';
            if ($code == 'id')
                return redirect()->route('web.id.temukan-kami');
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('sb.pages_id', 8)    // Content Find Us
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $section = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    -> whereIn('sb.sub_pages_id', [31, 37])  // Header & Hubungi Kami
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->get();
                $kontak = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sub_pages_slug', 'like', 'detail-kontak')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->first();
                $daftar_kontak = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    -> whereIn('sb.sub_pages_id', [33, 35, 34, 36])  // Alamat, Telp, Email, Fax
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->get();
            }
            $socialmedia = OfficialSocmedMarketplace::where('id', 1)
                ->first();
            return view('web.find-us', [
                'section' => $section ??= collect([]),
                'page' => $page,
                'code' => $code,
                'kontak' => $kontak ??= null,
                'socialmedia' => $socialmedia,
                'daftar_kontak' => $daftar_kontak ??= collect([]),
            ]);
        })->name('find-us');
        Route::get('/careers', function (string $code = null) {
            $code ??= 'id';
            if ($code == 'id')
                return redirect()->route('web.id.karir');
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('sb.pages_id', 7)    // Content Karir
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $section = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->whereIn('sb.sub_pages_id', [22, 23])  // Header & Content Middle
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->get();
                $rekrutmen_step = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sub_pages_slug', 'like', 'rekrutmen-%')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->get();
            }
            return view('web.careers', [
                'section' => $section ??= collect([]),
                'page' => $page,
                'code' => $code,
                'rekrutmen_step' => $rekrutmen_step ??= collect([]),
            ]);
        })->name('careers');
        Route::get('/factory-tour', function (string $code = null) {
            $code ??= 'id';
            if ($code == 'id')
                return redirect()->route('web.id.tur-pabrik');
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('sb.pages_id', 17)    // Content Tur Pabrik
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $header_description = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sb.pages_id', $page->pages_id)
                   ->where('sb.sub_pages_id', 49)    // Header Tur Pabrik
                    ->where('sb.sub_pages_status', 1)
                    ->first();
            }
            return view('web.factory-tour', [
                'page' => $page ??= null,
                'code' => $code,
                'descriptions' => $header_description ??= null,
            ]);
        })->name('factory-tour');
        Route::get('/vision-mission', function (string $code = null) {
            $code ??= 'id';
            if ($code == 'id')
                return redirect()->route('web.id.visi-misi');
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('sb.pages_id', 16)    // Content Visi Misi
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $header_description = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_id', 50)                  // Header Visi Misi
                    ->where('sb.sub_pages_status', 1)
                    ->first();
            }
            return view('web.vision-mission', [
                'page' => $page ??= null,
                'code' => $code,
                'descriptions' => $header_description ??= null,
            ]);
        })->name('company-profile');
        Route::get('/distributor', [DistributorController::class, 'distributor'])->name('distributor');
        Route::get('/products/{category_title?}/{product?}', [ProductController::class, 'products'])->name('products');
        Route::get('/international-market', [DistributorController::class, 'intermarket'])->name('intermarket');
    });
Route::post('/web-question', [HomeController::class, 'question'])->name('question');
Route::get('/change-language/{lang}/{url}/{remaining?}', [HomeController::class, 'changeLang']);
Route::get('/fetch/province/{id}', function (string $id) {
    $target = DB::table('ref_province')->where('country_id', $id)
        ->get([
            'code as value',
            'name as label'
        ]);
    return response()->json($target);
});
Route::get('/fetch/city/{id}', function (string $id) {
    $target = DB::table('ref_city')->where('province_id', $id)
        ->get([
            'id as value',
            'code',
            'name as label'
        ]);
    return response()->json($target);
});
Route::get('/fetch/district/{id}', function (string $id) {
    $target = DB::table('ref_district')->where('city_id', $id)
        ->get([
            'code as value',
            'name as label'
        ]);
    return response()->json($target);
});
Route::get('/fetch/subdistrict/{id}', function (string $id) {
    $target = DB::table('ref_subdistrict')->where('district', $id)
        ->get([
            'code as value',
            'name as label'
        ]);
    return response()->json($target);
});
