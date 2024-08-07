<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductcategoryController extends Controller
{
    //
    public function index()
    {
        $query = ProductCategory::query();
        $query->join('product_segment as ps', 'ps.segment_id', '=', 'products_category_translation.segment_id');
        $query->join('app_language as al', 'al.code', '=', 'pages_translation.language_code');
        $query->select([
            'category_title', 'ps.segment_title', 'al.name as language_name', 'al.code as language_code', 
        ]);

        $data = $query->get();
    }
}
