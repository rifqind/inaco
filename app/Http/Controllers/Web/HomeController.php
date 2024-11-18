<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use App\Models\Homebanner;
use App\Models\HomebannerTranslation;
use App\Models\InternationalMarket;
use App\Models\NewsTranslation;
use App\Models\OfficialSocmedMarketplace;
use App\Models\PageTranslation;
use App\Models\Product;
use App\Models\ProductCategoryTranslation;
use App\Models\ProductImage;
use App\Models\ProductSegment;
use App\Models\ProductTranslation;
use App\Models\RecipeImage;
use App\Models\RecipeTranslation;
use App\Models\SubpageTranslation;
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

    public function recipe(Request $request, string $code = null, $title = null)
    {
        $code ??= 'id';
        if ($code == 'id') {
            if ($request->currentPage) {
                // $link = route('web.id.resep', ['title' => $title]) . '?currentPage=' . $request->currentPage . '&category=' . $request->category;
                if ($title) {
                    $link = route('web.id.resep.kategori', ['cat_title' => $title]) . '?currentPage=' . $request->currentPage;
                } else {
                    $link = route('web.id.resep') . '?currentPage=' . $request->currentPage;
                }
                return redirect($link);
            } else
                return redirect()->route('web.id.resep', ['title' => $title]);
        }
        $data = $this->recipeGenerate($request, $code, $title);
        // if ($title) {
        //     $show = $this->recipeDetailGenerate($code, $title);
        //     return view('web.recipe-detail', [
        //         'recipe' => $show['recipe'],
        //         'recipeList' => $show['recipeList'],
        //         'code' => $show['code'],
        //         'image' => $show['image'],
        //     ]);
        // }

        return view('web.recipe', [
            'recipes' => $data['recipes'],
            'currentSum' => $data['currentSum'],
            'category' => $data['category'],
            'category_slug' => $data['category_slug'],
            'code' => $data['code'],
            'page' => $data['page'],
            'section' => $data['section'],
        ]);
    }

    public function resep(Request $request, $title = null)
    {
        $code = 'id';
        $data = $this->recipeGenerate($request, $code, $title);
        // if ($title) {
        //     $show = $this->recipeDetailGenerate($code, $title);
        //     return view('web.recipe-detail', [
        //         'recipe' => $show['recipe'],
        //         'recipeList' => $show['recipeList'],
        //         'code' => $show['code'],
        //         'image' => $show['image'],
        //     ]);
        // }
        return view('web.recipe', [
            'recipes' => $data['recipes'],
            'currentSum' => $data['currentSum'],
            'category' => $data['category'],
            'category_slug' => $data['category_slug'],
            'code' => $data['code'],
            'page' => $data['page'],
            'section' => $data['section'],
        ]);
    }

    private function recipeGenerate(Request $request, string $code, string $title = null)
    {
        $paginated = $request->paginated ?? 12;
        $currentPage = $request->currentPage ?? 1;
        $page = PageTranslation::where('language_code', $code)
            ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
            ->where('pages_slug', 'resep')
            ->where('pages_status', 1)
            ->first();
        $section = $page ? SubpageTranslation::where('language_code', $code)
            ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
            ->where('sub_pages_slug', 'like', 'bagian-%')
            ->where('sb.pages_id', $page->pages_id)
            ->where('sb.sub_pages_status', 1)
            ->get() : collect([]);

        // if ($title) {
        // $query = RecipeTranslation::query();
        // $query->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
        //     ->leftJoin('recipe_image as ri', 'r.recipe_id', '=', 'ri.recipe_id')
        //     ->select(['recipe_translation.*', 'r.*', 'ri.image_filename', 'ri.image_cover'])
        //     ->where('ri.image_cover', '!=', null) // Only join images that have a cover
        //     ->where('language_code', $code)
        //     ->where('r.recipe_status', 1)
        //     ->orderBy('r.create_date', 'desc')
        //     ->take(4);

        // $recipeList = $query->get();

        // // Loop through the recipe list to sanitize descriptions and assign images
        // foreach ($recipeList as $recipe) {
        //     $text = $recipe->recipe_description;
        //     $cleanText = strip_tags($text);
        //     $recipe->recipe_description = html_entity_decode($cleanText);

        //     // Get the image filename for the cover image
        //     if ($recipe->image_cover) {
        //         $recipe->recipe_image = $recipe->image_filename; // image already available from join
        //     } else {
        //         $recipe->recipe_image = null; // In case there's no image
        //     }
        // }

        // // Fetch single recipe based on slug
        // $recipe = RecipeTranslation::join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
        //     ->where('recipe_slug', $title)
        //     ->where('language_code', $code)
        //     ->first();

        // $image = RecipeImage::where('recipe_id', $recipe->recipe_id)->get();
        // $res = 4 - $image->count();
        // // dd($res);
        // if ($res > 0) {
        //     for ($i = 0; $i < $res; $i++) {
        //         foreach ($image as $item) {
        //             $image->push($item); // Duplicate the item and add it to the collection
        //             if ($image->count() >= 4) {
        //                 break 2; // Exit both loops if we reach 4 items
        //             }
        //         }
        //     }
        // }
        // $recipe->create_date = $this->formatDate($recipe->create_date);
        // return view('web.recipe-detail', [
        //     'recipe' => $recipe,
        //     'recipeList' => $recipeList,
        //     'code' => $code,
        //     'image' => $image,
        // ]);
        // }

        $productList = RecipeTranslation::where('language_code', $code)
            ->distinct()->pluck('product_id')->toArray();
        $categoryList = ProductTranslation::where('language_code', $code)
            ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
            ->whereIn('p.product_id', $productList)
            ->distinct()->pluck('category_id')->toArray();
        $categoryShow = ProductCategoryTranslation::where('language_code', $code)
            ->whereIn('category_id', $categoryList)
            ->get(['category_title', 'category_id', 'category_slug']);
        // dd($categoryShow);
        $query = RecipeTranslation::query();
        $query->where('recipe_translation.language_code', $code)
            ->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
            // ->join('products_translation as pt', 'p.product_id', '=', 'recipe_translation.product_id')
            ->join('products as p', 'p.product_id', '=', 'recipe_translation.product_id')
            ->join('products_category_translation as pct', 'pct.category_id', '=', 'p.category_id')
            // ->where('pt.language_code', $code)
            ->where('pct.language_code', $code)
            ->where('r.recipe_status', 1)
            ->select([
                'recipe_translation.*',
                'r.*',
                // 'pt.product_title',
                'pct.category_title',
                'pct.category_slug'
            ]);
        if ($title) {
            // if (!empty($request->category)) {
            $getCategoryId = ProductCategoryTranslation::where('language_code', $code)
                ->where('category_slug', $title)->value('category_id');
            $fetchProductList = Product::where('category_id', $getCategoryId)
                ->distinct()->pluck('product_id')->toArray();
            $query->whereIn('recipe_translation.product_id', $fetchProductList);
            // }
        }
        $recipes = $query->paginate($paginated, ['*'], 'page', $currentPage);
        $recipes->getCollection()->transform(function ($value) {
            $text = $value->recipe_description;
            $cleanText = strip_tags($text);
            $value->recipe_description = html_entity_decode($cleanText);
            $image_id = RecipeImage::where('recipe_id', $value->recipe_id)->value('image_cover');
            $value->recipe_image = RecipeImage::where('recipe_image_id', $image_id)
                ->value('image_filename');
            return $value;
        });
        $data = [];
        $data['recipes'] = $recipes;
        $data['currentSum'] = $recipes->count();
        $data['category'] = $categoryShow;
        $data['category_slug'] = $title;
        $data['code'] = $code;
        $data['page'] = $page;
        $data['section'] = $section;
        return $data;
    }

    public function recipeDetail(string $code, string $title)
    {
        $code ??= 'id';
        if ($code == 'id') {
            $link = route('web.id.resep.detail', ['title' => $title]);
            return redirect($link);
        }
        if ($title) {
            $query = RecipeTranslation::query();
            $query->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
                ->leftJoin('recipe_image as ri', 'r.recipe_id', '=', 'ri.recipe_id')
                ->select(['recipe_translation.*', 'r.*', 'ri.image_filename', 'ri.image_cover'])
                ->where('ri.image_cover', '!=', null) // Only join images that have a cover
                ->where('language_code', $code)
                ->where('r.recipe_status', 1)
                ->orderBy('r.create_date', 'desc')
                ->take(4);

            $recipeList = $query->get();

            // Loop through the recipe list to sanitize descriptions and assign images
            foreach ($recipeList as $recipe) {
                $text = $recipe->recipe_description;
                $cleanText = strip_tags($text);
                $recipe->recipe_description = html_entity_decode($cleanText);

                // Get the image filename for the cover image
                if ($recipe->image_cover) {
                    $recipe->recipe_image = $recipe->image_filename; // image already available from join
                } else {
                    $recipe->recipe_image = null; // In case there's no image
                }
            }

            // Fetch single recipe based on slug
            $recipe = RecipeTranslation::join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
                ->where('recipe_slug', $title)
                ->where('language_code', $code)
                ->first();

            $image = RecipeImage::where('recipe_id', $recipe->recipe_id)->get();
            $res = 4 - $image->count();
            // dd($res);
            if ($res > 0) {
                for ($i = 0; $i < $res; $i++) {
                    foreach ($image as $item) {
                        $image->push($item); // Duplicate the item and add it to the collection
                        if ($image->count() >= 4) {
                            break 2; // Exit both loops if we reach 4 items
                        }
                    }
                }
            }
            $recipe->create_date = $this->formatDate($recipe->create_date);
            return view('web.recipe-detail', [
                'recipe' => $recipe,
                'recipeList' => $recipeList,
                'code' => $code,
                'image' => $image,
            ]);
        }
    }

    public function resepDetail(string $title)
    {
        $code = 'id';
        if ($title) {
            $query = RecipeTranslation::query();
            $query->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
                ->leftJoin('recipe_image as ri', 'r.recipe_id', '=', 'ri.recipe_id')
                ->select(['recipe_translation.*', 'r.*', 'ri.image_filename', 'ri.image_cover'])
                ->where('ri.image_cover', '!=', null) // Only join images that have a cover
                ->where('language_code', $code)
                ->where('r.recipe_status', 1)
                ->orderBy('r.create_date', 'desc')
                ->take(4);

            $recipeList = $query->get();

            // Loop through the recipe list to sanitize descriptions and assign images
            foreach ($recipeList as $recipe) {
                $text = $recipe->recipe_description;
                $cleanText = strip_tags($text);
                $recipe->recipe_description = html_entity_decode($cleanText);

                // Get the image filename for the cover image
                if ($recipe->image_cover) {
                    $recipe->recipe_image = $recipe->image_filename; // image already available from join
                } else {
                    $recipe->recipe_image = null; // In case there's no image
                }
            }

            // Fetch single recipe based on slug
            $recipe = RecipeTranslation::join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
                ->where('recipe_slug', $title)
                ->where('language_code', $code)
                ->first();

            $image = RecipeImage::where('recipe_id', $recipe->recipe_id)->get();
            // $res = 4 - $image->count();
            // if ($res > 0) {
            //     for ($i = 0; $i < $res; $i++) {
            //         foreach ($image as $item) {
            //             $image->push($item); // Duplicate the item and add it to the collection
            //             if ($image->count() >= 4) {
            //                 break 2; // Exit both loops if we reach 4 items
            //             }
            //         }
            //     }
            // }
            $recipe->create_date = $this->formatDate($recipe->create_date);
            return view('web.recipe-detail', [
                'recipe' => $recipe,
                'recipeList' => $recipeList,
                'code' => $code,
                'image' => $image,
            ]);
        }
    }
    private function recipeDetailGenerate(string $code, string $title)
    {
        $query = RecipeTranslation::query();
        $query->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
            ->leftJoin('recipe_image as ri', 'r.recipe_id', '=', 'ri.recipe_id')
            ->select(['recipe_translation.*', 'r.*', 'ri.image_filename', 'ri.image_cover'])
            ->where('ri.image_cover', '!=', null) // Only join images that have a cover
            ->where('language_code', $code)
            ->where('r.recipe_status', 1)
            ->orderBy('r.create_date', 'desc')
            ->take(4);

        $recipeList = $query->get();

        // Loop through the recipe list to sanitize descriptions and assign images
        foreach ($recipeList as $recipe) {
            $text = $recipe->recipe_description;
            $cleanText = strip_tags($text);
            $recipe->recipe_description = html_entity_decode($cleanText);

            // Get the image filename for the cover image
            if ($recipe->image_cover) {
                $recipe->recipe_image = $recipe->image_filename; // image already available from join
            } else {
                $recipe->recipe_image = null; // In case there's no image
            }
        }

        // Fetch single recipe based on slug
        $recipe = RecipeTranslation::join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
            ->where('recipe_slug', $title)
            ->where('language_code', $code)
            ->first();

        $image = RecipeImage::where('recipe_id', $recipe->recipe_id)->get();
        $res = 4 - $image->count();
        // dd($res);
        if ($res > 0) {
            for ($i = 0; $i < $res; $i++) {
                foreach ($image as $item) {
                    $image->push($item); // Duplicate the item and add it to the collection
                    if ($image->count() >= 4) {
                        break 2; // Exit both loops if we reach 4 items
                    }
                }
            }
        }
        $recipe->create_date = $this->formatDate($recipe->create_date);
        $data = [];
        $data['recipe'] = $recipe;
        $data['recipeList'] = $recipeList;
        $data['code'] = $code;
        $data['image'] = $image;
        return $data;
    }

    public function katalog(Request $request, string $id, string $cat_title = null, string $productDetail = null)
    {
        $code = 'id';
        $data = $this->catalogGenerate($request, $code, $id, $cat_title, $productDetail);
        if ($productDetail) {
            $show = $this->catalogGenerate($request, $code, $id, $cat_title, $productDetail);
            return view('web.catalog-detail', [
                'detail' => $show['detail'],
                'products' => $show['products'],
                'code' => $show['code'],
                'fakeId' => $show['fakeId'],
                'cat_title' => $show['cat_title'],
                'cat_title_for_detail' => $show['cat_title_for_detail'],
            ]);
        }
        return view('web.catalog', [
            'products' => $data['products'],
            'recipes' => $data['recipes'],
            'segment' => $data['segment'],
            'catalog_image' => $data['catalog_image'],
            'code' => $data['code'],
            'fakeId' => $data['fakeId'],
            'cat_title_for_detail' => $data['cat_title_for_detail'],
            'cat_title' => $data['cat_title'],
        ]);
    }
    public function catalog(Request $request, string $code = null, string $id, string $cat_title = null, string $productDetail = null)
    {
        $code ??= 'id';
        if ($code == 'id') {
            if ($productDetail)
                return redirect()->route('web.id.katalog', [
                    'id' => $id,
                    'category_title' => $cat_title,
                    'product' => $productDetail
                ]);
            return redirect()->route('web.id.katalog', ['id' => $id, 'category_title' => $cat_title]);
        }
        $data = $this->catalogGenerate($request, $code, $id, $cat_title, $productDetail);
        if ($productDetail) {
            $show = $this->catalogGenerate($request, $code, $id, $cat_title, $productDetail);
            return view('web.catalog-detail', [
                'detail' => $show['detail'],
                'products' => $show['products'],
                'code' => $show['code'],
                'fakeId' => $show['fakeId'],
                'cat_title' => $show['cat_title'],
                'cat_title_for_detail' => $show['cat_title_for_detail'],
            ]);
        }
        return view('web.catalog', [
            'products' => $data['products'],
            'recipes' => $data['recipes'],
            'segment' => $data['segment'],
            'catalog_image' => $data['catalog_image'],
            'code' => $data['code'],
            'fakeId' => $data['fakeId'],
            'cat_title_for_detail' => $data['cat_title_for_detail'],
            'cat_title' => $data['cat_title'],
        ]);
    }

    private function catalogGenerate(Request $request, string $code = null, string $id, string $cat_title = null, string $productDetail = null)
    {
        $fakeId = $id;
        $segments = ProductSegment::get();
        if ($code == 'id') {
            foreach ($segments as $segment) {
                if (Str::slug($segment->segment_name) == $id) $id = $segment->segment_id;
            }
            // $id = match ($id) {
            //     'dewasa' => 1,
            //     'remaja' => 2,
            //     'anak' => 3,
            // };
        } else {
            foreach ($segments as $segment) {
                if (Str::slug($segment->segment_name_non_id) == $id) $id = $segment->segment_id;
            }
            // $id = match ($id) {
            //     'adult' => 1,
            //     'teenager' => 2,
            //     'children' => 3,
            // };
        }
        $query = ProductTranslation::query();
        $query->where('products_translation.language_code', $code)
            ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
            ->join('products_category_translation as pc', 'pc.category_id', '=', 'p.category_id')
            ->where('p.product_status', 1)
            ->where('segment_id', $id)
            ->where('pc.language_code', $code)
            ->orderBy('p.create_date', 'desc')
            ->select(['product_title', 'pc.category_slug', 'p.product_id', 'product_slug']);

        $cat_id = null;
        if ($cat_title) {
            $cat_id = ProductCategoryTranslation::where('category_slug', $cat_title)
                ->value('category_id');
            $cat_title_for_view = ProductCategoryTranslation::where('category_slug', $cat_title)
                ->value('category_title');
        }
        if ($cat_id)
            $query->where('p.category_id', $cat_id);

        //get all first
        $products = $query->get();
        $productListForDetail = $query->take(4)->get();
        foreach ($products as $key => $value) {
            # code...
            $image_id = ProductImage::where('product_id', $value->product_id)->value('image_cover');
            $value->product_image = ProductImage::where('product_image_id', $image_id)
                ->value('image_filename');
        }
        $recipes = null;

        if (!$products->isEmpty()) {
            $recipes = RecipeTranslation::where('recipe_translation.language_code', $code)
                ->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
                ->join('products as p', 'p.product_id', '=', 'recipe_translation.product_id')
                ->join('products_category_translation as pct', 'pct.category_id', '=', 'p.category_id')
                ->where('r.recipe_status', 1)
                ->where('pct.language_code', $code)
                ->where('pct.category_slug', $cat_title)
                ->select(['recipe_title', 'r.recipe_id', 'recipe_image', 'recipe_slug'])->get();
            foreach ($recipes as $value) {
                $image_id = RecipeImage::where('recipe_id', $value->recipe_id)->value('image_cover');
                $value->recipe_image = RecipeImage::where('recipe_image_id', $image_id)
                    ->value('image_filename');
            }
        }
        if ($productDetail) {
            $detail = ProductTranslation::where('product_slug', $productDetail)
                ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
                ->where('language_code', $code)
                ->first();
            // if (!$detail)
            //     abort(404);
            if ($detail) {
                $image_id = ProductImage::where('product_id', $detail->product_id)->value('image_cover');
                $detail->product_image = ProductImage::where('product_image_id', $image_id)
                    ->value('image_filename');
                foreach ($productListForDetail as $key => $value) {
                    # code...
                    $image_id = ProductImage::where('product_id', $value->product_id)->value('image_cover');
                    $value->product_image = ProductImage::where('product_image_id', $image_id)
                        ->value('image_filename');
                }
            }
            $show = [];
            $show['detail'] = $detail;
            $show['products'] = $productListForDetail;
            $show['code'] = $code;
            $show['fakeId'] = $fakeId;
            $show['cat_title'] = ($cat_title) ? $cat_title_for_view : null;
            $show['cat_title_for_detail'] = $cat_title;
            return $show;
        }
        $catalog_image = Homebanner::where('segment_id', $id)->value('banner_image');
        $data = [];
        $data['products'] = $products;
        $data['recipes'] = ($recipes) ? $recipes : collect([]);
        $data['segment'] = $id;
        $data['catalog_image'] = ($catalog_image) ? $catalog_image : null;
        $data['code'] = $code;
        $data['fakeId'] = $fakeId;
        $data['cat_title_for_detail'] = $cat_title;
        $data['cat_title'] = ($cat_title) ? $cat_title_for_view : null;
        return $data;
    }

    public function news(Request $request, string $code = null, string $id, string $title = null)
    {
        $code ??= 'id';
        if ($code == 'id') {
            ($id == 'articles') ? $id = 'artikel' : $id;
            return redirect()->route('web.id.berita', ['id' => $id, 'title' => $title]);
        }
        $data = $this->newsGenerate($request, $code, $id, $title);
        if ($title) {
            $show = $this->newsGenerate($request, $code, $id, $title);
            if ($data['news_category'] == 1) {
                return view('web.news-detail', [
                    'news' => $show['news'],
                    'id' => $show['id'],
                    'newsList' => $show['newsList'],
                    'code' => $show['code'],
                ]);
            } else {
                return view('web.press-release-detail', [
                    'news' => $show['news'],
                    'id' => $show['id'],
                    'newsList' => $show['newsList'],
                    'code' => $show['code'],
                ]);
            }
        }
        if ($data['news_category'] == 1) {
            return view('web.news', [
                'news' => $data['news'],
                'id' => $data['id'],
                'code' => $data['code'],
                'popularNews' => $data['popularNews'],
                'page' => $data['page'],
                'section' => $data['section']
            ]);
        } else {
            return view('web.press-release', [
                'news' => $data['news'],
                'id' => $data['id'],
                'code' => $data['code'],
                'popularNews' => $data['popularNews'],
                'page' => $data['page'],
                'section' => $data['section']
            ]);
        }
    }

    public function berita(Request $request, string $id, string $title = null)
    {
        $code = 'id';
        $data = $this->newsGenerate($request, $code, $id, $title);
        if ($title) {
            $show = $this->newsGenerate($request, $code, $id, $title);
            if ($data['news_category'] == 1) {
                return view('web.news-detail', [
                    'news' => $show['news'],
                    'id' => $show['id'],
                    'newsList' => $show['newsList'],
                    'code' => $show['code'],
                ]);
            } else {
                return view('web.press-release-detail', [
                    'news' => $show['news'],
                    'id' => $show['id'],
                    'newsList' => $show['newsList'],
                    'code' => $show['code'],
                ]);
            }
        }

        if ($data['news_category'] == 1) {
            return view('web.news', [
                'news' => $data['news'],
                'id' => $data['id'],
                'code' => $data['code'],
                'popularNews' => $data['popularNews'],
                'page' => $data['page'],
                'section' => $data['section']
            ]);
        } else {
            return view('web.press-release', [
                'news' => $data['news'],
                'id' => $data['id'],
                'code' => $data['code'],
                'popularNews' => $data['popularNews'],
                'page' => $data['page'],
                'section' => $data['section']
            ]);
        }
    }

    private function newsGenerate(Request $request, string $code = null, string $id, string $title = null)
    {
        $paginated = $request->paginated ?? 4;
        $currentPage = $request->currentPage ?? 1;
        //recheck
        if ($code == 'id')
            $news_category = $id === 'artikel' ? 1 : ($id === 'press-release' ? 2 : null);
        else
            $news_category = $id === 'articles' ? 1 : ($id === 'press-release' ? 2 : null);
        if (!$news_category)
            abort(404);

        $page = PageTranslation::where('language_code', $code)
            ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
            ->where('pages_slug', 'berita')
            ->where('pages_status', 1)
            ->first();
        $section = $page ? SubpageTranslation::where('language_code', $code)
            ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
            ->where('sub_pages_slug', 'like', ($news_category == 1) ? 'berita-bagian-%' : 'press-bagian-%')
            ->where('sb.pages_id', $page->pages_id)
            ->where('sb.sub_pages_status', 1)
            ->get() : collect([]);

        // dd($section);
        $query = NewsTranslation::query()
            ->where('language_code', $code)
            ->join('news as n', 'n.news_id', '=', 'news_translation.news_id')
            ->where('n.news_status', 1)
            ->where('n.news_category', $news_category)
            ->select([
                'news_translation.news_title',
                'news_translation.news_description',
                'n.create_date',
                'n.news_image',
                'count_views',
                'news_slug'
            ]);
        if ($title) {
            $news = $this->getNewsDetail($title);
            $newsList = $this->paginateAndFormatNews($query, 2);
            $show = [];
            $show['news'] = $news;
            $show['id'] = $id == 'artikel' ? 'articles' : $id;
            $show['newsList'] = $newsList;
            $show['code'] = $code;
            $show['news_category'] = $news_category;
            return $show;
        }

        $news = $this->paginateAndFormatNews($query, $paginated, $currentPage);
        $popular = $query->orderBy('count_views', 'desc');
        $popularNews = $this->paginateAndFormatNews($popular, $paginated, $currentPage);
        $data = [];
        $data['news'] = $news;
        $data['id'] = $id == 'artikel' ? 'articles' : $id;
        $data['code'] = $code;
        $data['popularNews'] = $popularNews;
        $data['page'] = $page;
        $data['section'] = $section;
        $data['news_category'] = $news_category;
        return $data;
    }

    public function products(Request $request, string $code = null, string $cat_title = null, string $productDetail = null)
    {
        $code ??= 'id';
        // if ($code == 'id') {
        // return redirect()->route('web.id.katalog', ['id' => $id, 'category_title' => $cat_title]);
        // }
        if ($code == 'id') {
            if ($productDetail)
                return redirect()->route('web.id.produk', [
                    // 'id' => $id,
                    'category_title' => $cat_title,
                    'product' => $productDetail
                ]);
            if ($cat_title) {
                $link = route('web.id.produk', ['category_title' => $cat_title]);
                return redirect($link);
            } else
                return redirect()->route('web.id.produk');
        }
        $data = $this->productGenerate($request, $code, $cat_title, $productDetail);
        if ($productDetail) {
            $show = $this->productGenerate($request, $code, $cat_title, $productDetail);
            return view('web.catalog-detail', [
                'detail' => $show['detail'],
                'products' => $show['products'],
                'code' => $show['code'],
                // 'fakeId' => $show['fakeId'],
                'cat_title' => $show['cat_title'],
                'cat_title_for_detail' => $show['cat_title_for_detail'],
            ]);
        }
        return view('web.catalog', [
            'products' => $data['products'],
            'recipes' => $data['recipes'],
            'segment' => $data['segment'],
            'catalog_image' => $data['catalog_image'],
            'code' => $data['code'],
            // 'fakeId' => $data['fakeId'],
            'cat_title_for_detail' => $data['cat_title_for_detail'],
            'cat_title' => $data['cat_title'],
        ]);
        // return view('web.product', [
        //     'products' => $data['products'],
        //     'category' => $data['category'],
        //     'category_id' => $data['category_id'],
        //     'code' => $data['code']
        // ]);
    }
    public function produk(Request $request, string $cat_title = null, string $productDetail = null)
    {
        $code = 'id';
        $data = $this->productGenerate($request, $code, $cat_title, $productDetail);
        if ($productDetail) {
            $show = $this->productGenerate($request, $code, $cat_title, $productDetail);
            return view('web.catalog-detail', [
                'detail' => $show['detail'],
                'products' => $show['products'],
                'code' => $show['code'],
                // 'fakeId' => $show['fakeId'],
                'cat_title' => $show['cat_title'],
                'cat_title_for_detail' => $show['cat_title_for_detail'],
            ]);
        }

        return view('web.catalog', [
            'products' => $data['products'],
            'recipes' => $data['recipes'],
            'segment' => $data['segment'],
            'catalog_image' => $data['catalog_image'],
            'code' => $data['code'],
            // 'fakeId' => $data['fakeId'],
            'cat_title_for_detail' => $data['cat_title_for_detail'],
            'cat_title' => $data['cat_title'],
        ]);
        // return view('web.product', [
        //     'products' => $data['products'],
        //     'category' => $data['category'],
        //     'category_id' => $data['category_id'],
        //     'code' => $data['code']
        // ]);
    }

    private function productGenerate(Request $request, string $code = null, string $cat_title = null, string $productDetail = null)
    {
        $query = ProductTranslation::query();
        $query->where('products_translation.language_code', $code)
            ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
            ->join('products_category_translation as pc', 'pc.category_id', '=', 'p.category_id')
            ->where('p.product_status', 1)
            ->where('pc.category_slug', $cat_title)
            // ->where('segment_id', $id)
            ->where('pc.language_code', $code)
            ->orderBy('p.create_date', 'desc')
            ->select(['product_title', 'pc.category_slug', 'p.product_id', 'product_slug']);

        $segment = ProductCategoryTranslation::where('category_slug', $cat_title)->value('segment_id');
        $cat_id = null;
        if ($cat_title) {
            $cat_id = ProductCategoryTranslation::where('category_slug', $cat_title)
                ->value('category_id');
            $cat_title_for_view = ProductCategoryTranslation::where('category_slug', $cat_title)
                ->value('category_title');
        }
        if ($cat_id)
            $query->where('p.category_id', $cat_id);

        //get all first
        $products = $query->get();
        $queryProductDetail = clone $query;
        $productListForDetail = $queryProductDetail->take(4)->get();
        foreach ($products as $key => $value) {
            # code...
            $image_id = ProductImage::where('product_id', $value->product_id)->value('image_cover');
            $value->product_image = ProductImage::where('product_image_id', $image_id)
                ->value('image_filename');
        }
        $recipes = null;

        if (!$products->isEmpty()) {
            $recipes = RecipeTranslation::where('recipe_translation.language_code', $code)
                ->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
                ->join('products as p', 'p.product_id', '=', 'recipe_translation.product_id')
                ->join('products_category_translation as pct', 'pct.category_id', '=', 'p.category_id')
                ->where('r.recipe_status', 1)
                ->where('pct.language_code', $code)
                ->where('pct.category_slug', $cat_title)
                ->select(['recipe_title', 'r.recipe_id', 'recipe_image', 'recipe_slug'])->get();
            foreach ($recipes as $value) {
                $image_id = RecipeImage::where('recipe_id', $value->recipe_id)->value('image_cover');
                $value->recipe_image = RecipeImage::where('recipe_image_id', $image_id)
                    ->value('image_filename');
            }
        }
        if ($productDetail) {
            $detail = ProductTranslation::where('product_slug', $productDetail)
                ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
                ->where('language_code', $code)
                ->first();
            // if (!$detail)
            //     abort(404);
            if ($detail) {
                $image_id = ProductImage::where('product_id', $detail->product_id)->value('image_cover');
                $detail->product_image = ProductImage::where('product_image_id', $image_id)
                    ->value('image_filename');
                foreach ($productListForDetail as $key => $value) {
                    # code...
                    $image_id = ProductImage::where('product_id', $value->product_id)->value('image_cover');
                    $value->product_image = ProductImage::where('product_image_id', $image_id)
                        ->value('image_filename');
                }
            }
            $show = [];
            $show['detail'] = $detail;
            $show['products'] = $productListForDetail;
            $show['code'] = $code;
            // $show['fakeId'] = $fakeId;
            $show['cat_title'] = ($cat_title) ? $cat_title_for_view : null;
            $show['cat_title_for_detail'] = $cat_title;
            return $show;
        }
        $catalog_image = Homebanner::where('segment_id', $segment)->value('banner_image');
        $data = [];
        $data['products'] = $products;
        $data['recipes'] = ($recipes) ? $recipes : collect([]);
        $data['segment'] = $segment;
        $data['catalog_image'] = ($catalog_image) ? $catalog_image : null;
        $data['code'] = $code;
        // $data['fakeId'] = $fakeId;
        $data['cat_title_for_detail'] = $cat_title;
        $data['cat_title'] = ($cat_title) ? $cat_title_for_view : null;
        return $data;
    }

    private function rawProductGenerate(Request $request, string $code = null, string $cat_title = null, string $productDetail = null)
    {
        $paginated = $request->paginated ?? 12;
        $currentPage = $request->currentPage ?? 1;
        $query = ProductTranslation::query();
        $query->where('products_translation.language_code', $code)
            ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
            ->join('products_category_translation as pc', 'pc.category_id', '=', 'p.category_id')
            ->where('p.product_status', 1)
            ->where('pc.language_code', $code)
            ->orderBy('p.category_id', 'asc')
            ->orderBy('p.create_date', 'desc')
            ->select(['product_title', 'p.product_id', 'product_slug', 'p.category_id', 'category_title', 'category_slug', 'segment_id']);

        $catArray = ProductTranslation::where('products_translation.language_code', $code)
            ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
            ->join('products_category_translation as pc', 'pc.category_id', '=', 'p.category_id')
            ->where('p.product_status', 1)
            ->where('pc.language_code', $code)->distinct()->pluck('p.category_id')->toArray();

        //get all first
        if ($request->category) {
            if (!empty($request->category)) {
                $query->where('pc.category_slug', $request->category);
            }
        }
        $cat_id = null;
        if ($cat_title) {
            $cat_id = ProductCategoryTranslation::where('category_slug', $cat_title)
                ->value('category_id');
            $cat_title_for_view = ProductCategoryTranslation::where('category_slug', $cat_title)
                ->value('category_title');
        }
        if ($cat_id)
            $query->where('p.category_id', $cat_id);
        // $catArray = $query->distinct()->pluck('category_id')->toArray();
        $catArray = array_values(array_unique($catArray));
        $paginatedQuery = clone $query;
        $products = $paginatedQuery->paginate($paginated, ['*'], 'page', $currentPage);
        $productListForDetail = $query->take(4)->get();
        if ($productDetail) {
            $detail = ProductTranslation::where('product_slug', $productDetail)
                ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
                ->where('language_code', $code)
                ->first();
            // if (!$detail)
            //     abort(404);
            if ($detail) {
                $image_id = ProductImage::where('product_id', $detail->product_id)->value('image_cover');
                $detail->product_image = ProductImage::where('product_image_id', $image_id)
                    ->value('image_filename');
                foreach ($productListForDetail as $key => $value) {
                    # code...
                    $image_id = ProductImage::where('product_id', $value->product_id)->value('image_cover');
                    $value->product_image = ProductImage::where('product_image_id', $image_id)
                        ->value('image_filename');
                }
            }
            $show = [];
            $show['detail'] = $detail;
            $show['products'] = $productListForDetail;
            $show['code'] = $code;
            // dd($cat_title_for_view);
            // $show['fakeId'] = $fakeId;
            $show['cat_title'] = ($cat_title) ? $cat_title_for_view : null;
            $show['cat_title_for_detail'] = $cat_title;
            // dd($show);
            return $show;
        }
        $categoryShow = ProductCategoryTranslation::where('language_code', $code)
            ->whereIn('category_id', $catArray)
            ->get(['category_title', 'category_id', 'category_slug']);
        foreach ($products as $key => $value) {
            # code...
            $image_id = ProductImage::where('product_id', $value->product_id)->value('image_cover');
            $value->product_image = ProductImage::where('product_image_id', $image_id)
                ->value('image_filename');
            $segment = ProductSegment::where('segment_id', $value->segment_id)->first();
            // if ($code == 'id') {
            //     $id = match ($value->segment_id) {
            //         1 => 'dewasa',
            //         2 => 'remaja',
            //         3 => 'anak',
            //     };
            // } else {
            //     $id = match ($value->segment_id) {
            //         1 => 'adult',
            //         2 => 'teenager',
            //         3 => 'children',
            //     };
            // }
            $value->segment_id = $code == 'id' ? $segment->segment_name : $segment->segment_name_non_id;
        }
        $data = [];
        $data['products'] = $products;
        $data['category'] = $categoryShow;
        $data['category_id'] = $request->category;
        $data['code'] = $code;
        return $data;
    }

    public function subPages(Request $request, string $code = null)
    {
        $route = Route::currentRouteName();
        $code ??= 'id';
        if ($route == 'web.about') {
            $page = PageTranslation::where('language_code', $code)
                ->where('pages_slug', 'about')
                ->first();
            $page->pages_description = strip_tags(html_entity_decode($page->pages_description));
            return view('web.about', ['page' => $page, 'code' => $code]);
        } else if ($route == 'web.awards')
            return view('web.awards');
        else if ($route == 'web.find-us')
            return view('web.find-us');
    }

    public function pages(Request $request, string $code = null)
    {
        $route = Route::currentRouteName();
        if ($route == 'web.id.tentang') {
            $code = 'id';
            // Fetch page details
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
            // if ($page) {
            //     $page->pages_description = strip_tags(html_entity_decode($page->pages_description));
            // }
            return view('web.about', [
                'page' => $page,
                'code' => $code,
                'descriptions' => $tentang_description ??= null,
                'list_year' => $tentang_list_tahun ??= collect([]),
            ]);
        } else if ($route == 'web.id.penghargaan') {
            $code = 'id';
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
                'award_list' => $award_list ??= collect([]),
            ]);
        } else if ($route == 'web.id.karir') {
            $code = 'id';
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
                'section' => $section ??= collect([]),
                'page' => $page,
                'code' => $code,
                'rekrutmen_step' => $rekrutmen_step ??= collect([]),
            ]);
        } else if ($route == 'web.id.temukan-kami') {
            $code = 'id';
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
                // $kontak = SubpageTranslation::where('language_code', $code)
                //     ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                //     ->where('sub_pages_slug', 'like', 'detail-kontak')
                //     ->where('sb.pages_id', $page->pages_id)
                //     ->where('sb.sub_pages_status', 1)
                //     ->first();
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
                'section' => $section ??= collect([]),
                'page' => $page ??= null,
                'code' => $code,
                // 'kontak' => $kontak ??= null,
                'socialmedia' => $socialmedia ??= null,
                'daftar_kontak' => $daftar_kontak ??= collect([]),
            ]);
        } else if ($route == 'web.id.tur-pabrik') {
            $code = 'id';
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
        } else if ($route == 'web.id.profil-perusahaan') {
            $code = 'id';
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
            return view('web.vision-mission', [
                'page' => $page ??= null,
                'code' => $code,
                'descriptions' => $tentang_description ??= null,
            ]);
        }
    }

    public function newpages(Request $request, string $code = null, string $pages_id)
    {
   //     $route = Route::currentRouteName();
   //     $route == 'web.id.profil-perusahaan') {
            $code = 'id';
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
              //  ->where('pages_slug', 'profil-perusahaan')
                ->where('pages_id', $pages_id)
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
            return view('web.vision-mission', [
                'page' => $page ??= null,
                'code' => $code,
                'descriptions' => $tentang_description ??= null,
            ]);
    }

    public function distributor(Request $request, string $code = null)
    {
        $code ??= 'id';
        if ($code == 'id') {
            return redirect()->route('web.id.distributor');
        }
        $data = $this->distributorGenerate($code);
        return view('web.distributor', [
            'distributor' => $data['distributor'],
            'bigCity' => $data['bigCity'],
            'page' => $data['page'],
            'code' => $code,
            'section' => $data['section'],
            'indonesiaISO' => $data['indonesiaISO']
        ]);
    }

    public function distributorIndonesia()
    {
        $code = 'id';
        $data = $this->distributorGenerate($code);
        return view('web.distributor', [
            'distributor' => $data['distributor'],
            'bigCity' => $data['bigCity'],
            'page' => $data['page'],
            'code' => $code,
            'section' => $data['section'],
            'indonesiaISO' => $data['indonesiaISO']
        ]);
    }

    private function distributorGenerate(string $code = null)
    {
        $page = PageTranslation::where('language_code', $code)
            ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
            ->where('pages_slug', 'distributor')
            ->where('pages_status', 1)
            ->first();

        $section = $page ? SubpageTranslation::where('language_code', $code)
            ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
            ->where('sub_pages_slug', 'like', 'bagian-%')
            ->where('sb.pages_id', $page->pages_id)
            ->where('sb.sub_pages_status', 1)
            ->get() : collect([]);

        $distributor = Distributor::join('ref_province as rp', 'rp.id', '=', 'distributor.province')
            // ->join('ref_city as rc', 'rc.id', '=', 'distributor.city')
            ->select([
                'distributor.province',
                'rp.name as province_name',
                'rp.iso as iso'
            ])->distinct();
        $distributorList = $distributor->get();
        $indonesiaISO = $distributor->pluck('iso');
        $bigCity = null;
        $data = [];
        $data['indonesiaISO'] = $indonesiaISO;
        $data['distributor'] = $distributorList;
        $data['bigCity'] = $bigCity;
        $data['page'] = $page;
        $data['section'] = $section;
        return $data;
    }

    public function Intermarket(Request $request, string $code = null)
    {
        $code ??= 'id';
        if ($code == 'id') {
            return redirect()->route('web.id.intermarket');
        }
        $data = $this->marketGenerate($code);
        return view('web.intermarket', [
            'code' => $code,
            'market' => $data['market'],
            'northAmerica' => $data['northAmerica'],
            'southAmerica' => $data['southAmerica'],
            'europe' => $data['europe'],
            'africa' => $data['africa'],
            'asia' => $data['asia'],
            'oceania' => $data['oceania'],
            'countryISO' => $data['countryISO'],
            'page' => $data['page'],
            'section' => $data['section'],
        ]);
    }

    public function intermarketInd()
    {
        $code = 'id';
        $data = $this->marketGenerate($code);
        return view('web.intermarket', [
            'code' => $code,
            'market' => $data['market'],
            'northAmerica' => $data['northAmerica'],
            'southAmerica' => $data['southAmerica'],
            'europe' => $data['europe'],
            'africa' => $data['africa'],
            'asia' => $data['asia'],
            'oceania' => $data['oceania'],
            'countryISO' => $data['countryISO'],
            'page' => $data['page'],
            'section' => $data['section'],
        ]);
    }

    private function marketGenerate(string $code)
    {
        $page = PageTranslation::where('language_code', $code)
            ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
            ->where('pages_slug', 'pasar-internasional')
            ->where('pages_status', 1)
            ->first();

        $section = $page ? SubpageTranslation::where('language_code', $code)
            ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
            ->where('sub_pages_slug', 'like', 'bagian-%')
            ->where('sb.pages_id', $page->pages_id)
            ->where('sb.sub_pages_status', 1)
            ->get() : collect([]);

        $market = InternationalMarket::join('ref_country as rc', 'rc.id', '=', 'international_market.country')
            ->select('rc.iso', 'rc.continent', 'rc.name')
            ->distinct()
            ->get();

        $countryISO = $market->pluck('iso')->unique();
        $northAmerica = $market->filter(fn($item) => $item->continent === 'North America');
        $southAmerica = $market->filter(fn($item) => $item->continent === 'South America');
        $europe = $market->filter(fn($item) => $item->continent === 'Europe');
        $africa = $market->filter(fn($item) => $item->continent === 'Africa');
        $asia = $market->filter(fn($item) => $item->continent === 'Asia');
        $oceania = $market->filter(fn($item) => $item->continent === 'Oceania');

        $data = [];
        $data['market'] = $market;
        $data['northAmerica'] = $northAmerica;
        $data['southAmerica'] = $southAmerica;
        $data['europe'] = $europe;
        $data['africa'] = $africa;
        $data['asia'] = $asia;
        $data['oceania'] = $oceania;
        $data['countryISO'] = $countryISO;
        $data['page'] = $page;
        $data['section'] = $section;
        return $data;
    }

    public function question(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'max:20', 'email'],
            'phone' => ['required', 'string', 'max:15'],
            'message' => ['required', 'string']
        ]);
        try {
            DB::beginTransaction();
            DB::table('web_questions')->insert($data);
            DB::commit();
            return response()->json(['message' => 'Sukses']);
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['error' => 'Gagal']);
        }
    }

    public function changeLang(Request $request, string $language, string $url, string $remainingPath = null)
    {
        // $language = $request->language;
        // $url = $request->url;
        // $remainingPath = $request->remainingPath;
        // dd($request->search);
        switch ($url) {
            case 'tentang-kami':
                $goalPath = 'about';
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
    private function getNewsDetail($slug)
    {
        $news = NewsTranslation::where('news_slug', $slug)
            ->join('news as n', 'n.news_id', '=', 'news_translation.news_id')
            ->first([
                'news_translation.news_title',
                'news_translation.news_description',
                'n.create_date',
                'n.news_image',
                'count_views',
                'news_slug'
            ]);

        $sessionKey = 'news_viewed_' . $news->news_slug;
        // dd(session()->all());
        if (!session($sessionKey)) {
            $news->count_views = $news->count_views + 1;
            NewsTranslation::where('news_slug', $slug)->update(['count_views' => $news->count_views]);
            session()->put($sessionKey, true);
        }

        $news->create_date = $this->formatDate($news->create_date);

        return $news;
    }

    private function paginateAndFormatNews($query, $paginated, $currentPage = 1)
    {
        $newsList = $query->paginate($paginated, ['*'], 'page', $currentPage);

        foreach ($newsList as $news) {
            $news->news_description = $this->formatDescription($news->news_description);
            $news->create_date = $this->formatDate($news->create_date);
        }

        return $newsList;
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
