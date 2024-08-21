<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\NewsTranslation;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use App\Models\RecipeTranslation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(String $code = null)
    {
        $recipes = RecipeTranslation::where('recipe_translation.language_code', ($code) ? $code : 'id')
            ->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
            ->join('products_translation as p', 'p.product_id', '=', 'recipe_translation.product_id')
            ->where('p.language_code', ($code) ? $code : 'id')
            ->where('r.recipe_status', 1)
            ->get(['recipe_translation.*', 'r.*', 'p.product_title']);

        $products = ProductTranslation::where('language_code', ($code) ? $code : 'id')
            ->where('p.product_status', 1)
            ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
            ->get(['products_translation.product_id', 'products_translation.product_title']);

        $news = NewsTranslation::where('language_code', ($code) ? $code : 'id')
            ->where('n.news_status', 1)
            ->join('news as n', 'n.news_id', '=', 'news_translation.news_id')
            ->get(['news_translation.news_title', 'news_translation.news_description', 'n.create_date', 'n.news_image']);

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
        }
        return view('web.index', [
            'recipes' => $recipes,
            'products' => $products,
            'news' => $news,
        ]);
    }

    public function recipe(Request $request, String $code = null)
    {
        if ($request->paginated) $paginated = $request->paginated;
        else $paginated = 12;
        if ($request->currentPage) $currentPage = $request->currentPage;
        else $currentPage = 1;

        $productList = ProductTranslation::where('language_code', ($code) ? $code : 'id')
            ->whereIn('product_id', RecipeTranslation::distinct()->pluck('product_id')->toArray())
            ->get(['product_id', 'product_title']);
        $query = RecipeTranslation::query();
        $query->where('recipe_translation.language_code', ($code) ? $code : 'id')
            ->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
            ->join('products_translation as p', 'p.product_id', '=', 'recipe_translation.product_id')
            ->where('p.language_code', ($code) ? $code : 'id')
            ->where('r.recipe_status', 1)
            ->select(['recipe_translation.*', 'r.*', 'p.product_title']);
        if ($request->product_id) {
            // dd($request->product_id);
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
        ]);
    }

    public function catalog(Request $request, String $id, String $code = null)
    {
        //get all first
        $products = ProductTranslation::where('products_translation.language_code', ($code) ? $code : 'id')
            ->join('products as p', 'p.product_id', '=', 'products_translation.product_id')
            ->join('products_category_translation as pc', 'pc.category_id', '=', 'p.category_id')
            ->where('p.product_status', 1)
            ->where('segment_id', $id)
            ->where('pc.language_code', ($code) ? $code : 'id')
            ->select(['product_title', 'p.product_id'])->get();

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
            $recipes = RecipeTranslation::where('recipe_translation.language_code', ($code) ? $code : 'id')
                ->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id')
                ->where('r.recipe_status', 1)
                ->where('product_id', $products[0]->product_id)
                ->select(['recipe_title', 'recipe_image'])->get();
        }
        return view('web.catalog', [
            'products' => $products,
            'recipes' => ($recipes) ? $recipes : [],
            'segment' => $id,
        ]);
    }

    public function news(Request $request, String $id, String $code = null)
    {
        $paginated = $request->paginated ?? 4;
        $currentPage = $request->currentPage ?? 1;

        $news_category = $id === 'articles' ? 1 : ($id === 'press-release' ? 2 : null);
        if (!$news_category) abort(404);

        $query = NewsTranslation::query()
            ->where('language_code', $code ?? 'id')
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
                'newsList' => $newsList
            ]);
        }

        $news = $this->paginateAndFormatNews($query, $paginated, $currentPage);

        return view('web.news', [
            'news' => $news,
            'id' => $id,
        ]);
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
