<?php

namespace App\Http\View\Composers;

use App\Models\AppLanguage;
use App\Models\MenuNavigation;
use App\Models\MenuNavigationTranslation;
use App\Models\ProductCategoryTranslation;
use App\Models\ProductSegment;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view)
    {
        $lang = request()->route('code');
        //    die($lang);
        $listofLanguage = AppLanguage::pluck('code')->toArray();
        if (!$lang)
            $lang = 'id';
        abort_if(!in_array($lang, AppLanguage::pluck('code')->toArray()), 404);
        $categories = ProductCategoryTranslation::where('language_code', $lang)
            ->join('products_category as pc', 'pc.category_id', '=', 'products_category_translation.category_id')
            ->where('pc.category_status', 1)
            ->get([
                'products_category_translation.*',
                'pc.*'
            ]);
        foreach ($categories as $key => $value) {
            # code...
            $thisSegment = ProductSegment::where('segment_id', $value->segment_id)->first();
            $categoryToShow = ($lang == 'id') ? strtolower($thisSegment->segment_name) : strtolower($thisSegment->segment_name_non_id);

            $value->segment = $categoryToShow;
        }
        $languageList = AppLanguage::get();
        $currentLangImage = AppLanguage::where('code', $lang)->first();
        if (!$currentLangImage) {
            $currentLangImage = AppLanguage::where('code', 'id')->first();
        }
        // $menuList = ['Company', 'Products', 'Recipe', 'Distributors', 'International Market', 'News', 'Career'];
        $menuList = MenuNavigationTranslation::join('menu_navigation as mn', 'mn.menu_id', '=', 'menu_navigation_translation.menu_id')
            ->where('parent_menu', 0)
            ->where('language_code', $lang)
            ->where('on_website', 1)
            ->orderBy('display_sequence')
            ->get();

        $childrenMenu = MenuNavigationTranslation::join('menu_navigation as mn', 'mn.menu_id', '=', 'menu_navigation_translation.menu_id')
            ->whereNot('parent_menu', 0)
            ->where('language_code', $lang)
            ->where('on_website', 1)
            ->orderBy('display_sequence')
            ->get();

        $childrenCheck = MenuNavigation::whereNot('parent_menu', 0)
            ->distinct()
            ->pluck('parent_menu');

        foreach ($menuList as $key => $value) {
            # code...
            if (in_array($value->menu_id, $childrenCheck->toArray())) {
                $value->hasChildren = true;
            } else
                $value->hasChildren = false;
        }
        // $headerScammer = MenuNavigationTranslation::join('menu_navigation as mn', 'mn.menu_id', '=', 'menu_navigation_translation.menu_id')
        //     ->whereIn('menu_navigation_translation.menu_title', $menuList)
        //     ->get(['menu_title', 'on_website'])
        //     ->mapWithKeys(function ($item) {
        //         return [$item->menu_title => $item->on_website];
        //     })
        //     ->toArray();
        // foreach ($menuList as $value) {
        //     if (!isset($headerScammer[$value])) {
        //         $headerScammer[$value] = 0;
        //     }
        // }
        $view->with([
            'category' => $categories,
            // 'header' => $headerScammer,
            'menuList' => $menuList,
            'childrenMenu' => $childrenMenu,
            'code' => $lang,
            'languages' => $languageList,
            'currentLangImage' => $currentLangImage,
        ]);
    }
}
