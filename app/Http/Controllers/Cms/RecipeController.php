<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\Recipe;
use App\Models\RecipeTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class RecipeController extends Controller
{
    //
    public function index()
    {
        $query = RecipeTranslation::query();
        $query->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id');
        $query->join('app_language as al', 'al.code', '=', 'recipe_translation.language_code');
        $query->join('products as p', 'p.product_id', '=', 'recipe_translation.product_id');
        $query->select([
            'recipe_translation.*', 'p.product_id', 'r.recipe_image', 'al.name as language_name'
        ]);

        //sementara
        $data = $query->get();
        foreach ($data as $key => $value) {
            # code...
            //search available languague, english is priority
            $getData = ProductTranslation::where('product_id', $value->product_id)->get();
            $translation = $getData->firstWhere('language_code', 'en');
            if (!$translation) $translation = $getData->first();

            $product_title = $translation->product_title . ' (' . $translation->language_code . ')';
            $value->product_title = $product_title;
            $languageList = RecipeTranslation::where('recipe_id', $value->recipe_id)
                ->pluck('language_code');
            $value->languageList = $languageList;
        }
        $product = Product::get();
        foreach ($product as $key => $value) {
            # code...
            $getData = ProductTranslation::where('product_id', $value->product_id)->get();
            $translation = $getData->firstWhere('language_code', 'en');
            if (!$translation) $translation = $getData->first();
            $product_title = $translation->product_title . ' (' . $translation->language_code . ')';
            $value->product_title = $product_title;
        }

        return view('cms.recipe.list_recipe', [
            'data' => $data,
            'product' => $product
        ]);
    }

    public function create(Request $request)
    {
        $languages = AppLanguage::select('code as value', 'name as label')->get();
        $product = Product::get();
        foreach ($product as $key => $value) {
            # code...
            $getData = ProductTranslation::where('product_id', $value->product_id)->get();
            $translation = $getData->firstWhere('language_code', 'en');
            if (!$translation) $translation = $getData->first();
            $product_title = $translation->product_title . ' (' . $translation->language_code . ')';
            $value->product_title = $product_title;
        }
        if ($request->recipe_id) {
            $data = Recipe::where('recipe_id', $request->recipe_id)->first();
            if ($data) {
                $pageTitleList = RecipeTranslation::where('recipe_id', $data->recipe_id)
                    ->get(['recipe_title', 'language_code']);
                foreach ($pageTitleList as $key => $value) {
                    # code...
                    $value->titles = $value->recipe_title . ' (' . $value->language_code . ')';
                }
                $titles = $pageTitleList->pluck('titles');
                $data->language_code = $pageTitleList->pluck('language_code');
                return view('cms.recipe.create_recipe', [
                    'languages' => $languages,
                    'data' => $data,
                    'titles' => $titles,
                    'product' => $product,
                ]);
            }
        }
        $data = new Recipe();
        $fillable = $data->getFillable();
        foreach ($fillable as $key) {
            $data->$key = null;
        }
        $data->recipe_id = null;
        $data->language_code = null;
        return view('cms.recipe.create_recipe', [
            'data' => $data,
            'languages' => $languages,
            'product' => $product
        ]);
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $data = $request->validate([
                'recipe_id' => ['sometimes', 'integer'],
                'product_id' => ['required', 'integer'],
                'recipe_title' => ['required', 'string', 'max:100'],
                'recipe_description' => ['required', 'string'],
                'language_code' => ['required', 'string'],
                'ingredient' => ['required', 'string'],
                'recipe_status' => ['required', 'integer'],
            ]);
            $recipe_id_used = null;
            $recipe_slug = Str::slug($data['recipe_title'], '-');
            if ($request->recipe_id) {
                $request->validate([
                    'recipe_image' => 'required',
                ]);
                $insertRecipeTranslation = RecipeTranslation::create([
                    'recipe_id' => $data['recipe_id'],
                    'language_code' => $data['language_code'],
                    'recipe_title' => $data['recipe_title'],
                    'recipe_description' => $data['recipe_description'],
                    'ingredient' => $data['ingredient'],
                    'product_id' => $data['product_id'],
                    'recipe_slug' => $recipe_slug,
                ]);
                $recipe_id_used = $data['recipe_id'];
            } else {
                $request->validate([
                    'recipe_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
                ]);
                if ($request->hasFile('recipe_image')) {
                    $file = $request->file('recipe_image');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/recipe/' . $fileName;

                    $insertRecipe = Recipe::create([
                        'create_date' => date('Y-m-d H:i:s'),
                        'recipe_image' => $fileName,
                        'recipe_status' => $data['recipe_status']
                    ]);
                    $insertRecipeTranslation = RecipeTranslation::create([
                        'recipe_id' => $insertRecipe->recipe_id,
                        'language_code' => $data['language_code'],
                        'recipe_title' => $data['recipe_title'],
                        'recipe_description' => $data['recipe_description'],
                        'ingredient' => $data['ingredient'],
                        'product_id' => $data['product_id'],
                        'recipe_slug' => $recipe_slug,
                    ]);
                    $file->move(public_path('data/recipe'), $fileName);
                    $recipe_id_used = $insertRecipe->recipe_id;
                }
            }
            $languageList = RecipeTranslation::where('recipe_id', $recipe_id_used)
                ->pluck('language_code');
            DB::commit();
            return response()->json([
                'message' => 'Success',
                'id' => $recipe_id_used,
                'code' => $languageList
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            if (isset($filePath) && File::exists(public_path($filePath))) {
                File::delete(public_path($filePath));
            }
            return response()->json([
                'error' => 'Error when storing data! ' . $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, String $id = null)
    {
        if ($request->isMethod('get')) {
            $query = RecipeTranslation::query();
            $query->join('recipe as r', 'r.recipe_id', '=', 'recipe_translation.recipe_id');
            $query->where('recipe_translation_id', $id)
                ->select([
                    'recipe_translation.*', 'r.*',
                ]);
            $data = $query->first();
            // dd($data);
            $usedLang = RecipeTranslation::where('recipe_id', $data->recipe_id)
                ->where('recipe_translation_id', '!=', $id)
                ->pluck('language_code');
            $lang = AppLanguage::pluck('code');
            $remainingLang = $lang->diff($usedLang);
            $languages = AppLanguage::whereIn('code', $remainingLang)
                ->select('code as value', 'name as label')
                ->get();
            $product = Product::get();
            foreach ($product as $key => $value) {
                # code...
                $getData = ProductTranslation::where('product_id', $value->product_id)->get();
                $translation = $getData->firstWhere('language_code', 'en');
                if (!$translation) $translation = $getData->first();
                $product_title = $translation->product_title . ' (' . $translation->language_code . ')';
                $value->product_title = $product_title;
            }

            return view('cms.recipe.update_recipe', [
                'data' => $data,
                'languages' => $languages,
                'product' => $product
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'recipe_id' => ['required', 'integer'],
                    'recipe_translation_id' => ['required', 'integer'],
                    'product_id' => ['required', 'integer'],
                    'recipe_title' => ['required', 'string', 'max:100'],
                    'recipe_description' => ['required', 'string'],
                    'language_code' => ['required', 'string'],
                    'ingredient' => ['required', 'string'],
                    'recipe_status' => ['required', 'integer'],
                    'recipe_image_update' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5048',
                ]);
                $updateRecipeTranslation = RecipeTranslation::where('recipe_translation_id', $data['recipe_translation_id']);
                $recipe_slug = Str::slug($data['recipe_title'], '-');
                $updateRecipeTranslation->update([
                    'language_code' => $data['language_code'],
                    'recipe_title' => $data['recipe_title'],
                    'ingredient' => $data['ingredient'],
                    'product_id' => $data['product_id'],
                    'recipe_description' => $data['recipe_description'],
                    'recipe_slug' => $recipe_slug,
                ]);
                $getRecipe = $updateRecipeTranslation->value('recipe_id');
                $updateRecipe = Recipe::where('recipe_id', $getRecipe);
                $updateRecipe->update([
                    'recipe_status' => $data['recipe_status']
                ]);

                if ($request->hasFile('recipe_image_update')) {
                    $file = $request->file('recipe_image_update');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/recipe/' . $fileName;

                    $getFileName = $updateRecipe->value('recipe_image');
                    $updateRecipe->update([
                        'recipe_image' => $fileName
                    ]);

                    //update file 
                    $file->move(public_path('data/recipe'), $fileName);
                    //previous path & delete it
                    $getFilePath = 'data/recipe/' . $getFileName;

                    if (isset($getFilePath) && File::exists(public_path($getFilePath))) {
                        File::delete(public_path($getFilePath));
                    }
                }
                DB::commit();
                return response()->json([
                    'message' => 'Success',
                ]);;
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                if (isset($filePath) && File::exists(public_path($filePath))) {
                    File::delete(public_path($filePath));
                }
                return response()->json([
                    'error' => 'Error updating data! ' . $th->getMessage()
                ]);
            }
        }
    }

    public function destroy(String $id)
    {
        try {
            //code...
            DB::beginTransaction();
            $deleteRecipeTranslation = RecipeTranslation::where('recipe_translation_id', $id);
            $getPage = $deleteRecipeTranslation->first();
            $sumOfPageTrans = RecipeTranslation::where('recipe_id', $getPage->recipe_id)->count();

            $deleteRecipeTranslation->delete();
            if ($sumOfPageTrans == 1) {
                $deleteRecipe = Recipe::where('recipe_id', $getPage->recipe_id);
                $fileName = $deleteRecipe->first();
                $filePath = 'data/recipe/' . $fileName->recipe_image;
                if (isset($filePath) && File::exists(public_path($filePath))) {
                    File::delete(public_path($filePath));
                }
                $deleteRecipe->delete();
            }

            DB::commit();
            return response()->json([
                'message' => 'Successfully deleted'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return response()->json([
                'error' => 'Error while deleting ' . $th->getMessage()
            ]);
        }
    }
}
