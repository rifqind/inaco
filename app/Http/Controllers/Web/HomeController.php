<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Models\Homebanner;
use App\Models\HomebannerTranslation;
use App\Models\NewsTranslation;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use App\Models\RecipeImage;
use App\Models\RecipeTranslation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    //
    public function index(string $code = null)
    {
        $code ??= 'id';
        $banner = HomebannerTranslation::where('language_code', $code)
            ->join('homebanner as h', 'h.banner_id', '=', 'homebanner_translation.banner_id')
            ->where('banner_status', 1)
            ->orderBy('display_sequence', 'asc')
            ->get();
        $recipes = RecipeTranslation::where('recipe_translation.language_code', $code)
            ->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
            ->join('products as p', 'p.product_id', '=', 'recipe_translation.product_id')
            ->join('products_category_translation as pct', 'pct.category_id', '=', 'p.category_id')
            ->where('pct.language_code', $code)
            ->where('r.recipe_status', 1)
            ->orderBy('r.create_date', 'desc')
            // ->limit(4)
            ->get(['recipe_translation.*', 'r.*', 'pct.category_title as product_title']);

        $products = ProductTranslation::where('products_translation.language_code', $code)
            ->where('p.product_status', 1)
            ->where('p.show_on_home', 1)
            ->where('pc.language_code', $code)
            ->orderBy('p.display_sequence_onhome', 'asc')
            ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
            ->join('products_category_translation as pc', 'pc.category_id', '=', 'p.category_id')
            ->limit(10)
            ->get(['products_translation.*', 'p.*', 'pc.category_slug']);

        // ->where('p.product_status', 1)
        // where('products_translation.language_code', $code)
        // ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
        // ->where('pc.language_code', $code)
        $news = NewsTranslation::where('language_code', $code)
            ->where('n.news_status', 1)
            ->join('news as n', 'n.news_id', '=', 'news_translation.news_id')
            ->orderBy('n.create_date', 'desc')
            ->limit(5)
            ->get([
                'news_translation.news_title',
                'news_translation.news_description',
                'news_translation.news_slug',
                'n.create_date',
                'n.news_image',
                'n.news_category'
            ]);

        foreach ($recipes as $key => $value) {
            # code...
            $text = $value->recipe_description;
            $cleanText = strip_tags($text);
            $value->recipe_description = html_entity_decode($cleanText);
            $image_id = RecipeImage::where('recipe_id', $value->recipe_id)->value('image_cover');
            $value->recipe_image = RecipeImage::where('recipe_image_id', $image_id)
                ->value('image_filename');
        }

        foreach ($products as $key => $value) {
            # code...
            $image_id = ProductImage::where('product_id', $value->product_id)->value('image_cover');
            $value->product_image = ProductImage::where('product_image_id', $image_id)
                ->value('image_filename');
        }

        foreach ($news as $key => $value) {
            # code...
            $text = $value->news_description;
            $cleanText = strip_tags($text);
            $cleanText = html_entity_decode($cleanText);
            $words = explode(' ', $cleanText);
            // Check if the word count is greater than 10
            if (count($words) > 17) {
                $firstTenWords = implode(' ', array_slice($words, 0, 17));
                $value->news_description = $firstTenWords . '...';
            } else {
                $value->news_description = $cleanText;
            }
            $value->create_date = date('d M Y', strtotime($value->create_date));
            if ($value->news_category == 1)
                $value->news_category = 'articles';
            else
                $value->news_category = 'press-release';
        }

        $texts = [
            'ar' => [
                'header' => 'تينتانغ INACO',
                'items' => [
                    ['title' => 'التقدير', 'desc' => 'جائزة INACO', 'image' => 'award.jpg', 'url' => route('web.awards', ['code' => $code])],
                    ['title' => 'حولنا', 'desc' => 'عن شركة INACO', 'image' => 'about.jpg', 'url' => route('web.about', ['code' => $code])],
                    ['title' => 'نموذج الشركة', 'desc' => 'معلومات عن ملف الشركة', 'image' => 'profile.jpg', 'url' => route('web.company-profile', ['code' => $code])],
                ],
            ],
            'id' => [
                'header' => 'Tentang INACO',
                'items' => [
                    ['title' => 'Penghargaan', 'desc' => 'Beberapa penghargaan Inaco', 'image' => 'award.jpg', 'url' => route('web.awards', ['code' => $code])],
                    ['title' => 'Tentang Kami', 'desc' => 'Tentang perusahaan Inaco', 'image' => 'about.jpg', 'url' => route('web.about', ['code' => $code])],
                    ['title' => 'Profil Perusahaan', 'desc' => 'Informasi tentang profil perusahaan', 'image' => 'profile.jpg', 'url' => route('web.company-profile', ['code' => $code])],
                ],
            ],
            'vi' => [
                'header' => 'Về INACO',
                'items' => [
                    ['title' => 'Giải thưởng', 'desc' => 'Một số giải thưởng của Inaco', 'image' => 'award.jpg', 'url' => route('web.awards', ['code' => $code])],
                    ['title' => 'Về Chúng Tôi', 'desc' => 'Về công ty Inaco', 'image' => 'about.jpg', 'url' => route('web.about', ['code' => $code])],
                    ['title' => 'Hồ Sơ Công Ty', 'desc' => 'Thông tin về hồ sơ công ty', 'image' => 'profile.jpg', 'url' => route('web.company-profile', ['code' => $code])],
                ],
            ],
            'default' => [
                'header' => 'About INACO',
                'items' => [
                    ['title' => 'Awards', 'desc' => 'Some awards of Inaco', 'image' => 'award.jpg', 'url' => route('web.awards', ['code' => $code])],
                    ['title' => 'About Us', 'desc' => 'About Inaco company', 'image' => 'about.jpg', 'url' => route('web.about', ['code' => $code])],
                    ['title' => 'Company Profile', 'desc' => 'Information about the company profile', 'image' => 'profile.jpg', 'url' => route('web.company-profile', ['code' => $code])],
                ],
            ],

        ];
        $firstText = $texts[$code] ?? $texts['default'];
        return view('web.index', [
            'recipes' => $recipes,
            'products' => $products,
            'news' => $news,
            'code' => $code,
            'firstText' => $firstText,
            'banner' => $banner,
        ]);
    }


    public function changeLang(Request $request, string $language, string $url, string $remainingPath = null)
    {
        // $language = $request->language;
        // $url = $request->url;
        // $remainingPath = $request->remainingPath;
        // dd($request->search);
        switch ($url) {
            case 'visi-misi':
                $goalPath = 'vision-mission';
                break;
            case 'penghargaan':
                $goalPath = 'awards';
                break;
            case 'temukan-kami':
                $goalPath = 'find-us';
                break;
            case 'karir':
                $goalPath = 'careers';
                break;
            case 'tur-pabrik':
                $goalPath = 'factory-tour';
                break;
            case 'profil-perusahaan':
                $goalPath = 'company-profile';
                break;
            case 'resep':
                $goalPath = 'recipe';
                if ($remainingPath != '') {
                    $explode_remaining = explode('$', $remainingPath);
                    if (sizeof($explode_remaining) > 1) {
                        if ($explode_remaining[0] == 'detail') {
                            $goalPath = 'recipe/detail/' . $explode_remaining[1];
                        } else {
                            $goalPath = 'recipe/category/' . $explode_remaining[1];
                        }
                    } else {
                        $recipe_id = RecipeTranslation::where('recipe_slug', $remainingPath)->value('recipe_id');
                        $recipe_slug = RecipeTranslation::where('language_code', $language)
                            ->where('recipe_id', operator: $recipe_id)
                            ->value('recipe_slug');
                        $goalPath = 'recipe/' . $recipe_slug;
                    }
                }
                break;
            case 'katalog':
                $goalPath = 'catalog';
                if ($remainingPath != '') {
                    // $remainingPath = match ($remainingPath) {
                    //     'dewasa' => 'adult',
                    //     'remaja' => 'teenager',
                    //     'anak' => 'children'
                    // };
                    $segments = ProductSegment::get();
                    foreach ($segments as $key => $value) {
                        # code...
                        if (Str::slug($value->segment_name) == $remainingPath) $remainingPath = Str::slug($value->segment_name_non_id);
                    }
                    $goalPath = 'catalog/' . $remainingPath;
                }
                break;
            case 'produk':
                $goalPath = 'products';
                if ($remainingPath != '') {
                    $explode_remaining = explode('$', $remainingPath);
                    $category_id = ProductCategoryTranslation::where('category_slug', $explode_remaining[0])->value('category_id');
                    $category_slug = ProductCategoryTranslation::where('language_code', $language)
                        ->where('category_id', $category_id)
                        ->value('category_slug');
                    if (sizeof($explode_remaining) > 1) {
                        $product_id = ProductTranslation::where('product_slug', $explode_remaining[1])->value('product_id');
                        $product_slug = ProductTranslation::where('language_code', $language)
                            ->where('product_id', $product_id)
                            ->value('product_slug');
                        $goalPath = 'products/' . $category_slug . '/' . $product_slug;
                    } else {
                        $goalPath = 'products/' . $category_slug;
                    }
                }
                break;
            case 'pasar-internasional':
                $goalPath = 'international-market';
                break;
            case 'berita':
                $goalPath = 'news';
                if ($remainingPath != '') {
                    $explode_remaining = explode('$', $remainingPath);
                    $explode_remaining[0] = match ($explode_remaining[0]) {
                        'artikel' => 'articles',
                        'press-release' => 'press-release',
                    };
                    if (sizeof($explode_remaining) > 1) {
                        $news_id = NewsTranslation::where('news_slug', $explode_remaining[1])->value('news_id');
                        $news_slug = NewsTranslation::where('language_code', $language)
                            ->where('news_id', $news_id)
                            ->value('news_slug');
                        $goalPath = 'news/' . $explode_remaining[0] . '/' . $news_slug;
                    } else
                        $goalPath = 'news/' . $explode_remaining[0];
                }
                break;
            case 'index':
                $goalPath = 'index';
            default:
                $goalPath = $url;
                if ($remainingPath != '') {
                    switch ($goalPath) {
                        case 'products':
                            $explode_remaining = explode('$', $remainingPath);
                            $category_id = ProductCategoryTranslation::where('category_slug', $explode_remaining[0])->value('category_id');
                            $category_slug = ProductCategoryTranslation::where('language_code', $language)
                                ->where('category_id', $category_id)
                                ->value('category_slug');
                            if (sizeof($explode_remaining) > 1) {
                                $product_id = ProductTranslation::where('product_slug', $explode_remaining[1])->value('product_id');
                                $product_slug = ProductTranslation::where('language_code', $language)
                                    ->where('product_id', $product_id)
                                    ->value('product_slug');
                                $goalPath = 'products/' . $category_slug . '/' . $product_slug;
                            } else {
                                $goalPath = 'products/' . $category_slug;
                            }
                            break;
                        case 'news':
                            if ($remainingPath != '') {
                                $explode_remaining = explode('$', $remainingPath);
                                if ($language == 'id') {
                                    $explode_remaining[0] = match ($explode_remaining[0]) {
                                        'articles' => 'artikel',
                                        'press-release' => 'press-release',
                                    };
                                }
                                if (sizeof($explode_remaining) > 1) {
                                    $news_id = NewsTranslation::where('news_slug', $explode_remaining[1])->value('news_id');
                                    $news_slug = NewsTranslation::where('language_code', $language)
                                        ->where('news_id', $news_id)
                                        ->value('news_slug');
                                    $goalPath = 'news/' . $explode_remaining[0] . '/' . $news_slug;
                                } else
                                    $goalPath = 'news/' . $explode_remaining[0];
                            }
                            break;
                        case 'catalog':
                            if ($remainingPath != '') {
                                if ($language == 'id') {
                                    // $remainingPath = match ($remainingPath) {
                                    //     'adult' => 'dewasa',
                                    //     'teenager' => 'remaja',
                                    //     'children' => 'anak'
                                    // };
                                    $segments = ProductSegment::get();
                                    foreach ($segments as $key => $value) {
                                        # code...
                                        if (Str::slug($value->segment_name_non_id) == $remainingPath) $remainingPath = Str::slug($value->segment_name);
                                    }
                                }
                                $goalPath = 'catalog/' . $remainingPath;
                            }
                            break;
                        case 'recipe':
                            if ($remainingPath != '') {
                                $explode_remaining = explode('$', $remainingPath);
                                if (sizeof($explode_remaining) > 1) {
                                    if ($explode_remaining[0] == 'detail') {
                                        $goalPath = 'recipe/detail/' . $explode_remaining[1];
                                    } else {
                                        $goalPath = 'recipe/category/' . $explode_remaining[1];
                                    }
                                } else {
                                    $recipe_id = RecipeTranslation::where('recipe_slug', $remainingPath)->value('recipe_id');
                                    $recipe_slug = RecipeTranslation::where('language_code', $language)
                                        ->where('recipe_id', operator: $recipe_id)
                                        ->value('recipe_slug');
                                    $goalPath = 'recipe/' . $recipe_slug;
                                }
                            }
                            break;
                        default:
                            break;
                    }
                }
                break;
        }
        $result = '/' . $language . '/' . $goalPath;
        if ($goalPath == 'index')
            $result = '/' . $language;
        if ($request->search)
            $result = $result . $request->search;
        // dd($result);
        return response()->json($result);
    }
    

    private function formatDescription($description)
    {
        $cleanText = strip_tags(html_entity_decode($description));
        $words = explode(' ', $cleanText);

        return count($words) > 17
            ? implode(' ', array_slice($words, 0, 17)) . '...'
            : $cleanText;
    }

    private function formatDate($date)
    {
        return date('d M Y', strtotime($date));
    }
}
