<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategoryTranslation;
use App\Models\ProductImage;
use App\Models\ProductSegment;
use App\Models\ProductTranslation;
use App\Models\Homebanner;
use App\Models\HomebannerTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    
    public function index(Request $request, string $cat_title = null, string $productDetail = null)
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
