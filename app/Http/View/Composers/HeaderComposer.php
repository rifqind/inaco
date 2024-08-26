<?php

namespace App\Http\View\Composers;

use App\Models\AppLanguage;
use App\Models\ProductCategoryTranslation;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view)
    {
        $lang = request()->route('code');
        if (!$lang) $lang = 'id';
        $categories = ProductCategoryTranslation::where('language_code', $lang)
            ->join('products_category as pc', 'pc.category_id', '=', 'products_category_translation.category_id')
            ->where('pc.category_status', 1)
            ->get([
                'products_category_translation.*',
                'pc.*'
            ]);
        foreach ($categories as $key => $value) {
            # code...
            $categoryToShow = match ($value->segment_id) {
                1 => 'dewasa',
                2 => 'remaja',
                3 => 'anak'
            };
            $value->segment = $categoryToShow;
        }
        $languageList = AppLanguage::get();
        $currentLangImage = AppLanguage::where('code', $lang)->first();
        $view->with([
            'category' => $categories,
            'code' => $lang,
            'languages' => $languageList,
            'currentLangImage' => $currentLangImage,
        ]);
    }
}
