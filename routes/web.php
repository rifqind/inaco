<?php

use App\Http\Controllers\Web\HomeController;
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
        Route::get('/about', function (string $code = null) {
            $code ??= 'id';
            if ($code == 'id')
                return redirect()->route('web.id.tentang');
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('pages_slug', 'tentang-kami')
                ->where('pages_status', 1)
                ->first();

            // Fetch tentang description
            if ($page) {
                $tentang_description = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sub_pages_slug', 'like', 'bagian-%')
                    ->where('sb.sub_pages_status', 1)
                    ->first();
            }
            // Fetch list of other years (excluding 'tentang-inaco')
            $tentang_list_tahun = collect();  // Initialize empty collection
            if ($page) {
                $tentang_list_tahun = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->where('sub_pages_slug', 'not like', 'bagian-%')
                    ->get();
            }
            // Sanitize the page description, if it exists
            if ($page) {
                $page->pages_description = strip_tags(html_entity_decode($page->pages_description));
            }
            return view('web.about', [
                'page' => $page,
                'code' => $code,
                'descriptions' => $tentang_description ??= null,
                'list_year' => $tentang_list_tahun ??= null,
            ]);
        })->name('about');
        Route::get('/awards', function (string $code = null) {
            $code ??= 'id';
            if ($code == 'id')
                return redirect()->route('web.id.penghargaan');
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('pages_slug', 'penghargaan')
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $tentang_description = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sub_pages_slug', 'like', 'bagian-%')
                    ->where('sb.sub_pages_status', 1)
                    ->first();
                $award_list = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->where('sub_pages_slug', 'not like', 'bagian-%')->get();
                $award_list = $award_list->map(function ($item) {
                    // Convert sub_pages_description to an integer
                    $item->sub_pages_description = (int) strip_tags(html_entity_decode($item->sub_pages_description));
                    return $item;
                })->sortBy('sub_pages_description');
            }

            return view('web.awards', [
                'page' => $page,
                'code' => $code,
                'descriptions' => $tentang_description ??= null,
                'award_list' => $award_list ??= null,
            ]);
        })->name('awards');
        Route::get('/find-us', function (string $code = null) {
            $code ??= 'id';
            if ($code == 'id')
                return redirect()->route('web.id.temukan-kami');
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('pages_slug', 'temukan-kami')
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $section = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sub_pages_slug', 'like', 'bagian-%')
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
                    ->where('sub_pages_slug', 'like', 'kontak-%')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->get();
            }
            $socialmedia = OfficialSocmedMarketplace::where('id', 1)
                ->first();
            return view('web.find-us', [
                'section' => $section ??= null,
                'page' => $page,
                'kontak' => $kontak ??= null,
                'socialmedia' => $socialmedia,
                'daftar_kontak' => $daftar_kontak ??= null,
            ]);
        })->name('find-us');
        Route::get('/careers', function (string $code = null) {
            $code ??= 'id';
            if ($code == 'id')
                return redirect()->route('web.id.karir');
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('pages_slug', 'karir')
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $section = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sub_pages_slug', 'like', 'bagian-%')
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
                'section' => $section ??= null,
                'page' => $page,
                'rekrutmen_step' => $rekrutmen_step ??= null,
            ]);
        })->name('careers');
        Route::get('/factory-tour', function (string $code = null) {
            $code ??= 'id';
            if ($code == 'id')
                return redirect()->route('web.id.tur-pabrik');
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('pages_slug', 'tur-pabrik')
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $tentang_description = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sub_pages_slug', 'like', 'bagian-%')
                    ->where('sb.sub_pages_status', 1)
                    ->first();
            }
            return view('web.factory-tour', [
                'page' => $page ??= null,
                'code' => $code,
                'descriptions' => $tentang_description ??= null,
            ]);
        })->name('factory-tour');
        Route::get('/company-profile', function (string $code = null) {
            $code ??= 'id';
            if ($code == 'id')
                return redirect()->route('web.id.profil-perusahaan');
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('pages_slug', 'profil-perusahaan')
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $tentang_description = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sub_pages_slug', 'like', 'bagian-%')
                    ->where('sb.sub_pages_status', 1)
                    ->first();
            }
            return view('web.company-profile', [
                'page' => $page ??= null,
                'code' => $code,
                'descriptions' => $tentang_description ??= null,
            ]);
        })->name('company-profile');
        Route::get('/distributor', [HomeController::class, 'distributor'])->name('distributor');
        Route::get('/products/{category_title?}/{product?}', [HomeController::class, 'products'])->name('products');
        Route::get('/international-market', [HomeController::class, 'intermarket'])->name('intermarket');
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
