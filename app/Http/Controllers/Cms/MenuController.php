<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use App\Models\MenuNavigation;
use App\Models\MenuNavigationTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $query = MenuNavigationTranslation::query();
        $query->join('menu_navigation as mn', 'mn.menu_id', '=', 'menu_navigation_translation.menu_id');
        $query->join('app_language as al', 'al.code', '=', 'menu_navigation_translation.language_code');
        $query->select([
            'menu_navigation_translation.menu_translation_id as id',
            'mn.menu_id as menu_id',
            'parent_menu',
            'menu_title',
            'menu_category',
            'on_website',
            'al.name as language_name'
        ]);

        //sementara
        $data = $query->get();
        foreach ($data as $key => $value) {
            # code...
            if ($value->parent_menu == 0) {
                $label = MenuNavigationTranslation::where('menu_id', $value->menu_id)->value('menu_title');
                $value->parent_title = $label;
            } else {
                $label = MenuNavigationTranslation::where('menu_id', $value->parent_menu)->value('menu_title');
                $value->parent_title = $label;
            }
        }
        return view('cms.menu.list_menu', [
            'data' => $data
        ]);
    }

    public function create()
    {
        $query = MenuNavigationTranslation::query();
        $query->join('menu_navigation as mn', 'mn.menu_id', '=', 'menu_navigation_translation.menu_id');
        $parent = $query->where('mn.parent_menu', 0)->select('menu_title as label', 'mn.menu_id as value')->get();

        $languages = AppLanguage::select('code as value', 'name as label')->get();
        return view('cms.menu.create_menu', [
            'parent' => $parent,
            'languages' => $languages,
        ]);
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $data = $request->validate([
                'parent_menu' => ['required', 'integer'],
                'menu_title' => ['required', 'string'],
                'menu_category' => ['required', 'integer'],
                'on_website' => ['required', 'integer'],
                'menu_web_url' => ['required', 'string'],
                'menu_cms_url' => ['required', 'string'],
                'icon_on_cms' => ['required', 'string'],
                'language_code' => ['required', 'string'],
                'display_sequence' => ['required', 'integer'],
            ]);
            $insertMenuNavigation = MenuNavigation::create([
                'parent_menu' => $data['parent_menu'],
                'on_website' => $data['on_website'],
                'menu_category' => $data['menu_category'],
                'icon_on_cms' => $data['icon_on_cms'],
                'display_sequence' => $data['display_sequence']
            ]);
            $insertMenuNavigationTranslation = MenuNavigationTranslation::create([
                'menu_id' => $insertMenuNavigation->menu_id,
                'language_code' => $data['language_code'],
                'menu_title' => $data['menu_title'],
                'menu_web_url' => $data['menu_web_url'],
                'menu_cms_url' => $data['menu_cms_url']
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Success'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'error' => 'Error when storing data! ' . $th
            ]);
        }
    }

    public function update(Request $request, String $id = null)
    {
        if ($request->isMethod('get')) {
            $query = MenuNavigationTranslation::query();
            $query->join('menu_navigation as mn', 'mn.menu_id', '=', 'menu_navigation_translation.menu_id');
            $parent = $query->where('mn.parent_menu', 0)->select('menu_title as label', 'mn.menu_id as value')->get();
            $data = MenuNavigationTranslation::where('menu_translation_id', $id)
                ->join('menu_navigation as mn', 'mn.menu_id', '=', 'menu_navigation_translation.menu_id')
                ->first();

            $languages = AppLanguage::select('code as value', 'name as label')->get();

            return view('cms.menu.update_menu', [
                'parent' => $parent,
                'languages' => $languages,
                'data' => $data,
            ]);
        } elseif ($request->isMethod('post')) {
            # code...
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'menu_id' => ['required', 'integer'],
                    'menu_translation_id' => ['required', 'integer'],
                    'parent_menu' => ['required', 'integer'],
                    'menu_title' => ['required', 'string'],
                    'menu_category' => ['required', 'integer'],
                    'on_website' => ['required', 'integer'],
                    'menu_web_url' => ['required', 'string'],
                    'menu_cms_url' => ['required', 'string'],
                    'icon_on_cms' => ['required', 'string'],
                    'language_code' => ['required', 'string'],
                    'display_sequence' => ['required', 'integer'],
                ]);
                $updateMenuNavigation = MenuNavigation::where('menu_id', $data['menu_id']);
                $updateMenuNavigationTranslation = MenuNavigationTranslation::where('menu_translation_id', $data['menu_translation_id']);

                $updateMenuNavigation->update([
                    'parent_menu' => $data['parent_menu'],
                    'on_website' => $data['on_website'],
                    'menu_category' => $data['menu_category'],
                    'icon_on_cms' => $data['icon_on_cms'],
                    'display_sequence' => $data['display_sequence']
                ]);

                $updateMenuNavigationTranslation->update([
                    'menu_id' => $data['menu_id'],
                    'language_code' => $data['language_code'],
                    'menu_title' => $data['menu_title'],
                    'menu_web_url' => $data['menu_web_url'],
                    'menu_cms_url' => $data['menu_cms_url']
                ]);
                DB::commit();
                return response()->json([
                    'message' => 'Success'
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    'error' => 'Error when updating data! ' . $th
                ]);
            }
        }
    }
}