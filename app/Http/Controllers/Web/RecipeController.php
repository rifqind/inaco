<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RecipeImage;
use App\Models\RecipeTranslation;
use App\Models\PageTranslation;
use App\Models\SubpageTranslation;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\ProductCategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    //

    public function index(Request $request, $title = null)
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
            ->orderBy('r.create_date', 'desc')
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
