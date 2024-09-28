<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCategoryTranslation;
use App\Models\ProductImage;
use App\Models\ProductSegment;
use App\Models\ProductTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class ProductController extends Controller
{
    //
    public function index()
    {
        $query = ProductTranslation::query();
        $query->join('products as p', 'p.product_id', '=', 'products_translation.product_id');
        $query->join('app_language as al', 'al.code', '=', 'products_translation.language_code');
        $query->join('products_category as pc', 'pc.category_id', '=', 'p.category_id');
        $query->select([
            'products_translation.*',
            'p.category_id',
            'al.name as language_name',
            'p.show_on_home',
            'p.display_sequence_onhome as display'
        ]);

        //sementara
        $categoryList = $query->distinct()->pluck('category_id')->toArray();
        $data = $query->get();
        foreach ($data as $key => $value) {
            # code...
            //search available languague, english is priority
            $getData = ProductCategoryTranslation::where('category_id', $value->category_id)->get();
            $translation = $getData->firstWhere('language_code', 'en');
            if (!$translation)
                $translation = $getData->first();

            $value->segment_name = ProductSegment::where('segment_id', $translation->segment_id)->value('segment_name');
            $category_title = $translation->category_title . ' (' . $translation->language_code . ')';
            $value->category_title = $category_title;
            $languageList = ProductCategoryTranslation::where('category_id', $value->category_id)
                ->pluck('language_code');
            $value->languageList = $languageList;
            $getImage = ProductImage::where('product_id', $value->product_id)->first();
            $value->image = ProductImage::where('product_image_id', $getImage->image_cover)
                ->value('image_filename');
        }
        $category = ProductCategory::whereIn('category_id', $categoryList)->get();
        foreach ($category as $key => $value) {
            # code...
            $getData = ProductCategoryTranslation::where('category_id', $value->category_id)->get();
            $translation = $getData->firstWhere('language_code', 'en');
            if (!$translation)
                $translation = $getData->first();
            $category_title = $translation->category_title . ' (' . $translation->language_code . ')';
            $value->category_title = $category_title;
        }

        return view('cms.products.list_products', [
            'data' => $data,
            'category' => $category,
        ]);
    }

    public function create(Request $request)
    {
        $languages = AppLanguage::select('code as value', 'name as label')->get();
        $getCategory = ProductCategory::get();
        foreach ($getCategory as $key => $value) {
            # code...
            $getData = ProductCategoryTranslation::where('category_id', $value->category_id)->get();
            $translation = $getData->firstWhere('language_code', 'en');
            if (!$translation)
                $translation = $getData->first();
            $category_title = $translation->category_title . ' (' . $translation->language_code . ')';
            $value->category_title = $category_title;
        }
        if ($request->product_id) {
            $data = Product::where('product_id', $request->product_id)->first();
            $image = ProductImage::where('product_id', $data->product_id)->first();
            if ($data) {
                $pageTitleList = ProductTranslation::where('product_id', $data->product_id)
                    ->get(['product_title', 'language_code']);
                foreach ($pageTitleList as $key => $value) {
                    # code...
                    $value->titles = $value->product_title . ' (' . $value->language_code . ')';
                }
                $titles = $pageTitleList->pluck('titles');
                $data->language_code = $pageTitleList->pluck('language_code');
                $data->product_image = $image->image_filename;
                return view('cms.products.create_products', [
                    'languages' => $languages,
                    'data' => $data,
                    'titles' => $titles,
                    'categories' => $getCategory,
                ]);
            }
        }
        $data = new Product();
        $fillable = $data->getFillable();
        foreach ($fillable as $key) {
            $data->$key = null;
        }
        $data->product_id = null;
        $data->language_code = null;
        return view('cms.products.create_products', [
            'data' => $data,
            'languages' => $languages,
            'categories' => $getCategory,
        ]);
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            // dd($request);
            $data = $request->validate([
                'product_id' => ['sometimes', 'integer'],
                'category_id' => ['required', 'integer'],
                'product_title' => ['required', 'string', 'max:100'],
                'product_description' => ['required', 'string'],
                'language_code' => ['required', 'string'],
                'product_url_tokopedia' => ['required', 'string'],
                'product_url_shopee' => ['required', 'string'],
                'product_url_lazada' => ['required', 'string'],
                'product_url_tiktokshop' => ['required', 'string'],
                'show_on_home' => ['required', 'integer'],
                'display_sequence_onhome' => ['required', 'integer'],
                'product_status' => ['required', 'integer'],
            ]);
            $product_id_used = null;
            $product_slug = Str::slug($data['product_title'], '-');
            $uploadedFiles = [];
            $fileCover = null;
            if ($request->product_id) {
                $request->validate([
                    'product_image' => 'required',
                ]);
                $insertProductTranslation = ProductTranslation::create([
                    'product_id' => $data['product_id'],
                    'language_code' => $data['language_code'],
                    'product_title' => $data['product_title'],
                    'product_description' => $data['product_description'],
                    'product_slug' => $product_slug,
                ]);
                $product_id_used = $data['product_id'];
            } else {
                $request->validate([
                    'product_image.*' => 'required|image|mimes:jpeg,png,jpg,gif',
                ]);
                if ($request->hasFile('product_image')) {
                    $insertProduct = Product::create([
                        'create_date' => date('Y-m-d H:i:s'),
                        'category_id' => $data['category_id'],
                        'product_url_tokopedia' => $data['product_url_tokopedia'],
                        'product_url_shopee' => $data['product_url_shopee'],
                        'product_url_lazada' => $data['product_url_lazada'],
                        'product_url_tiktokshop' => $data['product_url_tiktokshop'],
                        'show_on_home' => $data['show_on_home'],
                        'display_sequence_onhome' => $data['display_sequence_onhome'],
                        'product_status' => $data['product_status']
                    ]);

                    foreach ($request->file('product_image') as $key => $file) {
                        # code...
                        $imageDimensions = getimagesize($file);
                        // Check if the image dimensions are at least 545x307
                        if ($imageDimensions[0] < 296 || $imageDimensions[1] < 296) {
                            // return back()->withErrors(['banner_image' => 'The image must be at least 296x296 pixels.']);
                            return response()->json([
                                'error' => 'The image must be at least 296x296 pixels.'
                            ]);
                        }
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $filePath = 'data/product/' . $insertProduct->product_id;
                        //chec if folder exists
                        if (!File::exists(public_path($filePath))) {
                            File::makeDirectory(public_path($filePath), 0755, true);
                        }
                        $image = Image::read($file->path());
                        $resizedImage = $image->resize(296, 296, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                        // $resizedImage->save(public_path($filePath) . '/' . $fileName);
                        $quality = 100;
                        $resizedImage->save(public_path($filePath) . '/' . $fileName, $quality);
                        while (filesize(public_path($filePath) . '/' . $fileName) > 150 * 1024) {
                            $quality -= 5;
                            $resizedImage->save(public_path($filePath) . '/' . $fileName, $quality);
                            if ($quality <= 10)
                                break;
                        }
                        // $file->move(public_path($filePath), $fileName);
                        $uploadedFiles[] = public_path($filePath . '/' . $fileName);
                        if ($key == 0) {
                            $insertImage = ProductImage::create([
                                'image_filename' => $fileName,
                                'product_id' => $insertProduct->product_id
                            ]);
                            $fileCover = $insertImage->product_image_id;
                            ProductImage::where('product_image_id', $fileCover)
                                ->update([
                                    'image_cover' => $fileCover
                                ]);
                        } else {
                            $insertImage = ProductImage::create([
                                'image_filename' => $fileName,
                                'image_cover' => $fileCover,
                                'product_id' => $insertProduct->product_id
                            ]);
                        }
                    }

                    $insertProductTranslation = ProductTranslation::create([
                        'product_id' => $insertProduct->product_id,
                        'language_code' => $data['language_code'],
                        'product_title' => $data['product_title'],
                        'product_description' => $data['product_description'],
                        'product_slug' => $product_slug,
                    ]);
                    $product_id_used = $insertProduct->product_id;
                }
            }
            $languageList = ProductTranslation::where('product_id', $product_id_used)
                ->pluck('language_code');
            DB::commit();
            return response()->json([
                'message' => 'Success',
                'id' => $product_id_used,
                'code' => $languageList
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            foreach ($uploadedFiles as $file) {
                if (File::exists($file)) {
                    File::delete($file);
                }
            }
            return response()->json([
                'error' => 'Error when storing data! ' . $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, string $id = null)
    {
        if ($request->isMethod('get')) {
            $query = ProductTranslation::query();
            $query->join('products as p', 'p.product_id', '=', 'products_translation.product_id');
            $query->where('products_translation.product_translation_id', $id)
                ->select([
                    'products_translation.*',
                    'p.*',
                ]);
            $data = $query->first();
            $getCategory = ProductCategory::get();
            foreach ($getCategory as $key => $value) {
                # code...
                $getData = ProductCategoryTranslation::where('category_id', $value->category_id)->get();
                $translation = $getData->firstWhere('language_code', 'en');
                if (!$translation)
                    $translation = $getData->first();
                $category_title = $translation->category_title . ' (' . $translation->language_code . ')';
                $value->category_title = $category_title;
            }

            //only show remaining languages
            $usedLang = ProductTranslation::where('product_id', $data->product_id)
                ->where('product_translation_id', '!=', $id)
                ->pluck('language_code');
            $lang = AppLanguage::pluck('code');
            $remainingLang = $lang->diff($usedLang);
            $languages = AppLanguage::whereIn('code', $remainingLang)
                ->select('code as value', 'name as label')
                ->get();
            return view('cms.products.update_products', [
                'languages' => $languages,
                'data' => $data,
                'categories' => $getCategory
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                // dd($request);
                $data = $request->validate([
                    'product_translation_id' => ['required', 'integer'],
                    'product_id' => ['required', 'integer'],
                    'category_id' => ['required', 'integer'],
                    'product_title' => ['required', 'string', 'max:100'],
                    'product_description' => ['required', 'string'],
                    'language_code' => ['required', 'string'],
                    'product_url_tokopedia' => ['required', 'string'],
                    'product_url_shopee' => ['required', 'string'],
                    'product_url_lazada' => ['required', 'string'],
                    'product_url_tiktokshop' => ['required', 'string'],
                    'show_on_home' => ['required', 'integer'],
                    'display_sequence_onhome' => ['required', 'integer'],
                    'product_status' => ['required', 'integer'],
                    'product_image_update.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
                ]);
                $updateProductTranslation = ProductTranslation::where('product_translation_id', $data['product_translation_id']);
                $product_slug = Str::slug($data['product_title'], '-');
                $updateProductTranslation->update([
                    'language_code' => $data['language_code'],
                    'product_title' => $data['product_title'],
                    'product_description' => $data['product_description'],
                    'product_slug' => $product_slug,
                ]);
                $getProduct = $updateProductTranslation->value('product_id');
                $updateProduct = Product::where('product_id', $getProduct);
                $updateProduct->update([
                    'category_id' => $data['category_id'],
                    'product_url_tokopedia' => $data['product_url_tokopedia'],
                    'product_url_shopee' => $data['product_url_shopee'],
                    'product_url_lazada' => $data['product_url_lazada'],
                    'product_url_tiktokshop' => $data['product_url_tiktokshop'],
                    'show_on_home' => $data['show_on_home'],
                    'display_sequence_onhome' => $data['display_sequence_onhome'],
                    'product_status' => $data['product_status']
                ]);
                $fileCover = null;
                $uploadedFiles = [];
                if ($request->hasFile('product_image_update')) {
                    $filePath = 'data/product/' . $data['product_id'];
                    $getImage = ProductImage::where('product_id', $data['product_id'])
                        ->get();
                    foreach ($getImage as $key => $value) {
                        # code...
                        $path = $filePath . '/' . $value->image_filename;
                        if (isset($path) && File::exists(public_path($path))) {
                            File::delete(public_path($path));
                        }
                        $value->delete();
                    }
                    foreach ($request->file('product_image_update') as $key => $file) {
                        # code...
                        $imageDimensions = getimagesize($file);
                        // Check if the image dimensions are at least 545x307
                        if ($imageDimensions[0] < 296 || $imageDimensions[1] < 296) {
                            // return back()->withErrors(['banner_image' => 'The image must be at least 296x296 pixels.']);
                            return response()->json([
                                'error' => 'The image must be at least 296x296 pixels.'
                            ]);
                        }
                        $filePath = 'data/product/' . $data['product_id'];
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $image = Image::read($file->path());
                        $resizedImage = $image->resize(296, 296, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                        // $resizedImage->save(public_path($filePath) . '/' . $fileName);
                        $quality = 100;
                        $resizedImage->save(public_path($filePath) . '/' . $fileName, $quality);
                        while (filesize(public_path($filePath) . '/' . $fileName) > 150 * 1024) {
                            $quality -= 5;
                            $resizedImage->save(public_path($filePath) . '/' . $fileName, $quality);
                            if ($quality <= 10)
                                break;
                        }
                        // $file->move(public_path($filePath), $fileName);
                        $uploadedFiles[] = public_path($filePath . '/' . $fileName);
                        if ($key == 0) {
                            $insertImage = ProductImage::create([
                                'image_filename' => $fileName,
                                'product_id' => $data['product_id']
                            ]);
                            $fileCover = $insertImage->product_image_id;
                            ProductImage::where('product_image_id', $fileCover)
                                ->update([
                                    'image_cover' => $fileCover
                                ]);
                        } else {
                            $insertImage = ProductImage::create([
                                'image_filename' => $fileName,
                                'image_cover' => $fileCover,
                                'product_id' => $data['product_id']
                            ]);
                        }
                    }
                }
                DB::commit();
                return response()->json([
                    'message' => 'Success',
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                foreach ($uploadedFiles as $file) {
                    if (File::exists($file)) {
                        File::delete($file);
                    }
                }
                return response()->json([
                    'error' => 'Error updating data! ' . $th->getMessage()
                ]);
            }
        }
    }

    public function destroy(string $id)
    {
        try {
            //code...
            DB::beginTransaction();
            $deleteProductTranslation = ProductTranslation::where('product_translation_id', $id);
            $getPage = $deleteProductTranslation->first();
            $sumOfPageTrans = ProductTranslation::where('product_id', $getPage->product_id)->count();

            $deleteProductTranslation->delete();
            if ($sumOfPageTrans == 1) {
                $deleteProduct = Product::where('product_id', $getPage->product_id);
                $filePath = 'data/product/' . $getPage->product_id;
                $getImage = ProductImage::where('product_id', $getPage->product_id)
                    ->get();
                foreach ($getImage as $key => $value) {
                    # code...
                    $path = $filePath . '/' . $value->image_filename;
                    if (isset($path) && File::exists(public_path($path))) {
                        File::delete(public_path($path));
                    }
                    $value->delete();
                }
                $deleteProduct->delete();
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
