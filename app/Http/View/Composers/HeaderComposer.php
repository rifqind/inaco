<?php

namespace App\Http\View\Composers;

use App\Models\AppLanguage;
use App\Models\MenuNavigationTranslation;
use App\Models\ProductCategoryTranslation;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view)
    {
        $lang = request()->route('code');
        if (!$lang)
            $lang = 'id';
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
                1 => ($lang == 'id') ? 'dewasa' : 'adult',
                2 => ($lang == 'id') ? 'remaja' : 'teenager',
                3 => ($lang == 'id') ? 'anak' : 'children'
            };

            $value->segment = $categoryToShow;
        }
        $languageList = AppLanguage::get();
        $currentLangImage = AppLanguage::where('code', $lang)->first();
        if (!$currentLangImage) {
            AppLanguage::where('code', 'id')->first();
        }
        $menuList = ['Company', 'Products', 'Recipe', 'Distributors', 'International Market', 'News', 'Career'];
        $headerScammer = MenuNavigationTranslation::join('menu_navigation as mn', 'mn.menu_id', '=', 'menu_navigation_translation.menu_id')
            ->whereIn('menu_navigation_translation.menu_title', $menuList)
            ->get(['menu_title', 'on_website'])
            ->mapWithKeys(function ($item) {
                return [$item->menu_title => $item->on_website];
            })
            ->toArray();
        foreach ($menuList as $value) {
            if (!isset($headerScammer[$value])) {
                $headerScammer[$value] = 0;
            }
        }
        $view->with([
            'category' => $categories,
            'header' => $headerScammer,
            'code' => $lang,
            'languages' => $languageList,
            'currentLangImage' => $currentLangImage,
        ]);
    }
}
