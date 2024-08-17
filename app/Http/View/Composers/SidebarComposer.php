<?php

namespace App\Http\View\Composers;

use App\Models\MenuNavigation;
use App\Models\MenuNavigationTranslation;
use Illuminate\View\View;

class SidebarComposer
{
    public function compose(View $view)
    {
        // Retrieve the necessary data for the sidebar
        $children_check = MenuNavigation::where('parent_menu', '!=', 0)
            ->distinct()
            ->pluck('parent_menu');
        $data = MenuNavigation::where('parent_menu', 0)->orderBy('display_sequence')->get(); // Replace this with your actual data retrieval logic
        foreach ($data as $key => $value) {
            # code...
            if (in_array($value->menu_id, $children_check->toArray())) {
                $value->hasChildren = true;
            } else $value->hasChildren = false;
            //search available languague, english is priority
            $getData = MenuNavigationTranslation::where('menu_id', $value->menu_id)->get();
            //check if language with code en exists if isnt exist get first row
            $translation = $getData->firstWhere('language_code', 'en');
            if (!$translation) $translation = $getData->first();
            $value->menu_title = $translation->menu_title;
            $value->menu_web_url = $translation->menu_web_url;
            $value->menu_cms_url = $translation->menu_cms_url;
        }
        $sidebarItems = $data;
        $childrenItems = MenuNavigation::where('parent_menu', '!=', 0)->orderBy('display_sequence')->get();
        foreach ($childrenItems as $key => $value) {
            # code...
            //search available languague, english is priority
            $getData = MenuNavigationTranslation::where('menu_id', $value->menu_id)->get();
            //check if language with code en exists if isnt exist get first row
            $translation = $getData->firstWhere('language_code', 'en');
            if (!$translation) $translation = $getData->first();
            $value->menu_title = $translation->menu_title;
            $value->menu_web_url = $translation->menu_web_url;
            $value->menu_cms_url = $translation->menu_cms_url;
        }

        // dd($sidebarItems);
        // Share the data with the view
        $view->with([
            'sidebarItems' => $sidebarItems,
            'childrenItems' => $childrenItems
        ]);
    }
}
