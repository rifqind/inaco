<?php

namespace App\Http\View\Composers;

use App\Models\MenuNavigation;
use App\Models\MenuNavigationTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SidebarComposer
{
    public function compose(View $view)
    {
        // Retrieve the necessary data for the sidebar
        $children_check = MenuNavigation::where('parent_menu', '!=', 0)
            ->distinct()
            ->pluck('parent_menu');
        $role = DB::table('roles_permissions')
            ->join('permissions as p', 'p.id', '=', 'roles_permissions.permission_id')
            ->where('role_id', auth()->user()->role_id)
            ->pluck('permission_name')->toArray();
        // $data = MenuNavigation::where('parent_menu', 0)
        //     ->join('menu_navigation_translation as mn', 'mn.menu_id', '=', 'menu_navigation.menu_id')
        //     ->where('mn.menu_title', '!=', 'Settings')
        //     ->where('on_cms', 1)
        //     ->whereIn('mn.menu_title', $role)
        //     ->orderBy('display_sequence')
        //     ->get();
        $data = MenuNavigation::where('parent_menu', 0)
            ->joinSub(
                MenuNavigationTranslation::select('menu_id', 'menu_title', 'menu_web_url', 'menu_cms_url')
                    ->whereIn('menu_translation_id', function ($query) {
                        $query->selectRaw('MIN(menu_translation_id)')
                            ->from('menu_navigation_translation')
                            ->whereRaw('language_code = "en" OR menu_id NOT IN (SELECT menu_id FROM menu_navigation_translation WHERE language_code = "en")')
                            ->groupBy('menu_id');
                    }),
                'mn',
                'mn.menu_id',
                '=',
                'menu_navigation.menu_id'
            )
            ->where('mn.menu_title', '!=', 'Settings')
            ->where('on_cms', 1)
            ->whereIn('mn.menu_title', $role)
            ->orderBy('display_sequence')
            ->get();
        foreach ($data as $key => $value) {
            # code...
            if (isset($children_check) && in_array($value->menu_id, $children_check->toArray())) {
                $value->setAttribute('hasChildren', true);
            } else {
                $value->setAttribute('hasChildren', false);
            }
            //search available languague, english is priority
            // $getData = MenuNavigationTranslation::where('menu_id', $value->menu_id)->get();
            //check if language with code en exists if isnt exist get first row
            // $translation = $getData->firstWhere('language_code', 'en') ?? $getData->first();
            // if ($translation) {
            //     $value->menu_title = $translation->menu_title;
            //     $value->menu_web_url = $translation->menu_web_url;
            //     $value->menu_cms_url = $translation->menu_cms_url;
            // }
        }
        $sidebarItems = $data;
        $childrenItems = MenuNavigation::where('parent_menu', '!=', 0)
            ->where('on_cms', 1)
            // ->join('menu_navigation_translation as mn', 'mn.menu_id', '=', 'menu_navigation.menu_id')
            ->whereIn('parent_menu', $data->pluck('menu_id')->toArray())
            ->orderBy('display_sequence')
            ->get();
        foreach ($childrenItems as $key => $value) {
            # code...
            //search available languague, english is priority
            $getData = MenuNavigationTranslation::where('menu_id', $value->menu_id)->get();
            //check if language with code en exists if isnt exist get first row
            $translation = $getData->firstWhere('language_code', 'en');
            if (!$translation)
                $translation = $getData->first();
            $value->menu_title = $translation->menu_title;
            $value->menu_web_url = $translation->menu_web_url;
            $value->menu_cms_url = $translation->menu_cms_url;
        }

        $showSettings = in_array('Settings', $role);
        $role_name = DB::table('roles')->where('id', auth()->user()->role_id)->first();
        if ($role_name->role_name == 'Super Admin') $showSettings = true;
        else $showSettings = false;
        // Share the data with the view
        $view->with([
            'sidebarItems' => $sidebarItems,
            'childrenItems' => $childrenItems,
            'showSettings' => $showSettings
        ]);
    }
}
