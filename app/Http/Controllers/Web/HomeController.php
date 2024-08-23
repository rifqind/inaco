<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use App\Models\NewsTranslation;
use App\Models\PageTranslation;
use App\Models\ProductCategoryTranslation;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use App\Models\RecipeTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    //
    public function index(String $code = null)
    {
        if ($code == 'webappcms') {
            // dd($code);
            return redirect()->route('login');
        }
        $code ??= 'id';
        $recipes = RecipeTranslation::where('recipe_translation.language_code', $code)
            ->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
            ->join('products_translation as p', 'p.product_id', '=', 'recipe_translation.product_id')
            ->where('p.language_code', $code)
            ->where('r.recipe_status', 1)
            ->get(['recipe_translation.*', 'r.*', 'p.product_title']);

        $products = ProductTranslation::where('language_code', $code)
            ->where('p.product_status', 1)
            ->where('p.show_on_home', 1)
            ->orderBy('p.display_sequence_onhome', 'asc')
            ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
            ->get(['products_translation.*', 'p.*']);

        $news = NewsTranslation::where('language_code', $code)
            ->where('n.news_status', 1)
            ->join('news as n', 'n.news_id', '=', 'news_translation.news_id')
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
            if ($value->news_category == 1) $value->news_category = 'articles';
            else $value->news_category = 'press-release';
        }
        return view('web.index', [
            'recipes' => $recipes,
            'products' => $products,
            'news' => $news,
            'code' => $code,
        ]);
    }

    public function recipe(Request $request, String $code = null)
    {
        $paginated = $request->paginated ?? 12;
        $currentPage = $request->currentPage ?? 1;
        $code ??= 'id';

        if ($request->title) {
            $query = RecipeTranslation::query();
            $query->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
                ->select(['recipe_translation.*', 'r.*']);
            $recipeList = $query->where('language_code', $code)
                ->where('r.recipe_status', 1)->get();
            foreach ($recipeList as $key => $value) {
                # code...
                $text = $value->recipe_description;
                $cleanText = strip_tags($text);
                $value->recipe_description = html_entity_decode($cleanText);
            }
            $recipe = $query->where('recipe_slug', $request->title)->first();
            $recipe->create_date = $this->formatDate($recipe->create_date);
            return view('web.recipe-detail', [
                'recipe' => $recipe,
                'recipeList' => $recipeList,
                'code' => $code,
            ]);
        }

        $productList = ProductTranslation::where('language_code', $code)
            ->whereIn('product_id', RecipeTranslation::distinct()->pluck('product_id')->toArray())
            ->get(['product_id', 'product_title']);
        $query = RecipeTranslation::query();
        $query->where('recipe_translation.language_code', $code)
            ->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
            ->join('products_translation as p', 'p.product_id', '=', 'recipe_translation.product_id')
            ->where('p.language_code', $code)
            ->where('r.recipe_status', 1)
            ->select(['recipe_translation.*', 'r.*', 'p.product_title']);
        if ($request->product_id) {
            if (!empty($request->product_id)) $query->where('recipe_translation.product_id', $request->product_id);
        }
        $recipes = $query->paginate($paginated, ['*'], 'page', $currentPage);
        $recipes->getCollection()->transform(function ($value) {
            $text = $value->recipe_description;
            $cleanText = strip_tags($text);
            $value->recipe_description = html_entity_decode($cleanText);
            return $value;
        });
        return view('web.recipe', [
            'recipes' => $recipes,
            'currentSum' => $recipes->count(),
            'products' => $productList,
            'product_id' => $request->product_id,
            'code' => $code,
        ]);
    }

    public function catalog(Request $request, String $code = null, String $id, String $cat_title = null)
    {
        $code ??= 'id';
        $id = match ($id) {
            'dewasa' => 1,
            'remaja' => 2,
            'anak' => 3,
        };
        $query = ProductTranslation::query();
        $query->where('products_translation.language_code', $code)
            ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
            ->join('products_category_translation as pc', 'pc.category_id', '=', 'p.category_id')
            ->where('p.product_status', 1)
            ->where('segment_id', $id)
            ->where('pc.language_code', $code)
            ->select(['product_title', 'p.product_id']);

        $cat_id = null;
        if ($cat_title) {
            $cat_id = ProductCategoryTranslation::where('category_slug', $cat_title)
                ->value('category_id');
        }
        if ($cat_id) $query->where('p.category_id', $cat_id);
        //get all first
        $products = $query->get();
        foreach ($products as $key => $value) {
            # code...
            $image_id = ProductImage::where('product_id', $value->product_id)->value('image_cover');
            $value->product_image = ProductImage::where('product_image_id', $image_id)
                ->value('image_filename');
        }
        // dd($products);
        //undefined
        $recipes = null;
        if (!$products->isEmpty()) {
            $recipes = RecipeTranslation::where('recipe_translation.language_code', $code)
                ->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
                ->where('r.recipe_status', 1)
                ->where('product_id', $products[0]->product_id)
                ->select(['recipe_title', 'recipe_image'])->get();
        }
        return view('web.catalog', [
            'products' => $products,
            'recipes' => ($recipes) ? $recipes : [],
            'segment' => $id,
            'code' => $code,
        ]);
    }
    public function news(Request $request, String $code = null, String $id)
    {
        $paginated = $request->paginated ?? 4;
        $currentPage = $request->currentPage ?? 1;
        $code ??= 'id';
        $news_category = $id === 'articles' ? 1 : ($id === 'press-release' ? 2 : null);
        if (!$news_category) abort(404);

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
                'news_slug'
            ]);

        if ($request->title) {
            $news = $this->getNewsDetail($request->title);
            $newsList = $this->paginateAndFormatNews($query, 2);

            return view('web.news-detail', [
                'news' => $news,
                'id' => $id,
                'newsList' => $newsList,
                'code' => $code,
            ]);
        }

        $news = $this->paginateAndFormatNews($query, $paginated, $currentPage);

        return view('web.news', [
            'news' => $news,
            'id' => $id,
            'code' => $code,
        ]);
    }

    public function pages(Request $request, String $code = null)
    {
        $route = Route::currentRouteName();
        if ($route == 'web.about') {
            $page = PageTranslation::where('language_code', $code)
                ->first();
            $page->pages_description = strip_tags(html_entity_decode($page->pages_description));
            return view('web.about', ['page' => $page]);
        }
    }

    public function distributor(Request $request, String $code = null)
    {
        $distributor = Distributor::join('ref_province as rp', 'rp.id', '=', 'distributor.province')
            ->join('ref_city as rc', 'rc.id', '=', 'distributor.city')
            ->get([
                'distributor.*',
                'rp.id as province_id',
                'rp.name as province_name',
                'rc.id as city_id',
                'rc.name as city_name',
            ]);
        foreach ($distributor as $key => $value) {
            # code...
            $exploded_city = explode(' ', $value->city_name, 2);
            $city_name = $exploded_city[1];
            $value->city_name = $city_name;
            //explode first word, how to?
        }
        return view('web.distributor', ['distributor' => $distributor]);
    }

    public function Intermarket(Request $request, String $code = null) {
        return view('web.intermarket');
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
                'news_slug'
            ]);

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
