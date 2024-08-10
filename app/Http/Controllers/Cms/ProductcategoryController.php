<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use App\Models\ProductCategory;
use App\Models\ProductCategoryTranslation;
use App\Models\ProductSegment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductcategoryController extends Controller
{
    //
    public function index()
    {
        $query = ProductCategoryTranslation::query();
        $query->join('product_segment as ps', 'ps.segment_id', '=', 'products_category_translation.segment_id');
        $query->join('products_category as pc', 'pc.category_id', '=', 'products_category_translation.category_id');
        $query->join('app_language as al', 'al.code', '=', 'products_category_translation.language_code');
        $query->select([
            'category_translation_id as id', 'pc.category_id',
            'category_title', 'ps.segment_name', 'al.name as language_name', 'al.code as language_code',
        ]);

        $data = $query->get();
        foreach ($data as $key => $value) {
            # code...
            $languageList = ProductCategoryTranslation::where('category_id', $value->category_id)->pluck('language_code');
            $value->languageList = $languageList;
        }

        return view('cms.product_category.list_product_category', [
            'data' => $data,
        ]);
    }

    public function create(Request $request)
    {
        $languages = AppLanguage::select('code as value', 'name as label')->get();
        $segments = ProductSegment::select('segment_id as value', 'segment_name as label')->get();
        if ($request) {
            $data = ProductCategory::where('category_id', $request->category_id)->first();
            if ($data) {
                $titleList = ProductCategoryTranslation::where('category_id', $data->category_id)
                    ->get(['category_title', 'language_code']);
                foreach ($titleList as $key => $value) {
                    # code...
                    $value->titles = $value->category_title . ' (' . $value->language_code . ')';
                }
                $titles = $titleList->pluck('titles');
                $data->language_code = $titleList->pluck('language_code');
                return view('cms.product_category.create_product_category', [
                    'languages' => $languages,
                    'data' => $data,
                    'titles' => $titles,
                    'segments' => $segments
                ]);
            }
        }

        $data = new ProductCategory();
        $fillable = $data->getFillable();
        foreach ($fillable as $key) {
            $data->$key = null;
        }
        $data->category_id = null;
        $data->language_code = null;
        return view('cms.product_category.create_product_category', [
            'languages' => $languages,
            'data' => $data,
            'segments' => $segments
        ]);
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            // dd($request);
            $data = $request->validate([
                'category_id' => ['sometimes', 'integer'],
                'segment_id' => ['required', 'integer'],
                'category_title' => ['required', 'string', 'max:100'],
                'category_description' => ['required', 'string'],
                'language_code' => ['required', 'string'],
                'category_status' => ['required', 'integer']
            ]);
            $category_id_used = null;
            $category_slug = Str::slug($data['category_title'], '-');
            if ($request->category_id) {
                $data['category_image'] = $request->validate([
                    'category_image' => 'required'
                ]);
                $insertProductCategoryTrans = ProductCategoryTranslation::create([
                    'category_id' => $data['category_id'],
                    'language_code' => $data['language_code'],
                    'segment_id' => $data['segment_id'],
                    'category_title' => $data['category_title'],
                    'category_description' => $data['category_description'],
                    'category_slug' => $category_slug,
                ]);
                $category_id_used = $data['category_id'];
            } else {
                $data['category_image'] = $request->validate([
                    'category_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048'
                ]);
                if ($request->hasFile('category_image')) {
                    $file = $request->file('category_image');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/product/category/' . $fileName;

                    $insertProductCategory = ProductCategory::create([
                        'category_image' => $fileName,
                        'create_date' => date('Y-m-d H:i:s'),
                        'category_status' => $data['category_status']
                    ]);
                    $insertProductCategoryTrans = ProductCategoryTranslation::create([
                        'category_id' => $insertProductCategory->category_id,
                        'language_code' => $data['language_code'],
                        'segment_id' => $data['segment_id'],
                        'category_title' => $data['category_title'],
                        'category_description' => $data['category_description'],
                        'category_slug' => $category_slug,
                    ]);
                    $file->move(public_path('data/product/category'), $fileName);
                    $category_id_used = $insertProductCategory->category_id;
                }
            }
            $languageList = ProductCategoryTranslation::where('category_id', $category_id_used)
                ->pluck('language_code');
            DB::commit();
            return response()->json([
                'message' => 'Success',
                'id' => $category_id_used,
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
            $query = ProductCategoryTranslation::query();
            $query->join('products_category as pc', 'pc.category_id', '=', 'products_category_translation.category_id');
            $query->where('category_translation_id', $id);
            $query->select([
                'products_category_translation.*', 'pc.category_image', 'pc.category_status'
            ]);

            $data = $query->first();
            //only show remaining languages
            $usedLang = ProductCategoryTranslation::where('category_id', $data->category_id)
                ->where('category_translation_id', '!=', $id)
                ->pluck('language_code');
            $lang = AppLanguage::pluck('code');
            $remainingLang = $lang->diff($usedLang);
            $languages = AppLanguage::whereIn('code', $remainingLang)
                ->select('code as value', 'name as label')
                ->get();
            $segments = ProductSegment::select('segment_id as value', 'segment_name as label')->get();
            return view('cms.product_category.update_product_category', [
                'languages' => $languages,
                'data' => $data,
                'segments' => $segments
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'category_translation_id' => ['required', 'integer'],
                    'category_id' => ['required', 'integer'],
                    'segment_id' => ['required', 'integer'],
                    'category_title' => ['required', 'string', 'max:100'],
                    'category_description' => ['required', 'string'],
                    'language_code' => ['required', 'string'],
                    'category_status' => ['required', 'integer'],
                    'category_image_update' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5048'
                ]);

                $updateProductCategoryTrans = ProductCategoryTranslation::where('category_translation_id', $data['category_translation_id']);
                $category_slug = Str::slug($data['category_title'], '-');

                $updateProductCategoryTrans->update([
                    'language_code' => $data['language_code'],
                    'segment_id' => $data['segment_id'],
                    'category_title' => $data['category_title'],
                    'category_description' => $data['category_description'],
                    'category_slug' => $category_slug,
                ]);
                $getCategory = $updateProductCategoryTrans->value('category_id');
                $updateProductCategory = ProductCategory::where('category_id', $getCategory);
                $updateProductCategory->update([
                    'category_status' => $data['category_status'],
                ]);

                if ($request->hasFile('category_image_update')) {
                    $file = $request->file('category_image_update');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/product/category/' . $fileName;

                    $getFileName = $updateProductCategory->value('category_image');
                    $updateProductCategory->update([
                        'category_image' => $fileName
                    ]);

                    //update file 
                    $file->move(public_path('data/product/category'), $fileName);
                    //previous path & delete it
                    $getFilePath = 'data/product/category/' . $getFileName;

                    if (isset($getFilePath) && File::exists(public_path($getFilePath))) {
                        File::delete(public_path($getFilePath));
                    }
                }
                DB::commit();
                return response()->json([
                    'message' => 'Success',
                ]);
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

    public function destroy(String $id) {
        try {
            //code...
            DB::beginTransaction();
            $deleteProductCategoryTrans = ProductCategoryTranslation::where('category_translation_id', $id);
            $getProductCategory = $deleteProductCategoryTrans->first();
            $sumOfCategory = ProductCategoryTranslation::where('category_id', $getProductCategory->category_id)->count();

            $deleteProductCategoryTrans->delete();
            if ($sumOfCategory == 1) {
                $deleteCategory = ProductCategory::where('category_id', $getProductCategory->category_id);
                $fileName = $deleteCategory->first();
                $filePath = 'data/product/category/' . $fileName->category_image;
                if (isset($filePath) && File::exists(public_path($filePath))) {
                    File::delete(public_path($filePath));
                }
                $deleteCategory->delete();
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
