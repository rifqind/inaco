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
            'al.name as language_name',
            'al.code as language_code'
        ]);

        //sementara
        $data = $query->get();
        foreach ($data as $key => $value) {
            # code...
            if ($value->parent_menu == 0) {
                // $label = MenuNavigationTranslation::where('menu_id', $value->menu_id)->value('menu_title');
                $value->parent_title = 'As Parent';
            } else {
                $label = MenuNavigationTranslation::where('menu_id', $value->parent_menu)->value('menu_title');
                $language = MenuNavigationTranslation::where('menu_id', $value->parent_menu)->value('language_code');
                $value->parent_title = $label . ' (' . $language . ')';
            }
            $languageList = MenuNavigationTranslation::where('menu_id', $value->menu_id)->pluck('language_code');
            $value->languageList = $languageList;
        }
        return view('cms.menu.list_menu', [
            'data' => $data
        ]);
    }

    public function create(Request $request)
    {
        $languages = AppLanguage::select('code as value', 'name as label')->get();
        $query = MenuNavigationTranslation::query();
        $query->join('menu_navigation as mn', 'mn.menu_id', '=', 'menu_navigation_translation.menu_id');
        $parent = $query->where('mn.parent_menu', 0)->select('menu_title as label', 'mn.menu_id as value')->get();

        if ($request) {
            $data = MenuNavigation::where('menu_id', $request->menu_id)->first();
            if ($data) {
                $menuTitleList = MenuNavigationTranslation::where('menu_id', $data->menu_id)
                    ->get(['menu_title', 'language_code']);
                foreach ($menuTitleList as $key => $value) {
                    # code...
                    $value->titles = $value->menu_title . ' (' . $value->language_code . ')';
                }
                $titles = $menuTitleList->pluck('titles');
                $data->parent_check = 1;
                $data->language_code = $menuTitleList->pluck('language_code');
                return view('cms.menu.create_menu', [
                    'data' => $data,
                    'parent' => $parent,
                    'languages' => $languages,
                    'titles' => $titles
                ]);
            }
        }
        $data = new MenuNavigation();
        $fillable = $data->getFillable();
        foreach ($fillable as $key) {
            $data->$key = null;
        }
        $data->menu_id = null;
        $data->parent_check = null;
        $data->language_code = null;
        return view('cms.menu.create_menu', [
            'parent' => $parent,
            'languages' => $languages,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $data = $request->validate([
                'menu_id' => ['sometimes', 'integer'],
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
            $menu_id_used = null;
            if ($request->menu_id) {
                $insertMenuNavigationTranslation = MenuNavigationTranslation::create([
                    'menu_id' => $data['menu_id'],
                    'language_code' => $data['language_code'],
                    'menu_title' => $data['menu_title'],
                    'menu_web_url' => $data['menu_web_url'],
                    'menu_cms_url' => $data['menu_cms_url']
                ]);
                $menu_id_used = $data['menu_id'];
            } else {
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
                $menu_id_used = $insertMenuNavigation->menu_id;
            }
            $languageList = MenuNavigationTranslation::where('menu_id', $menu_id_used)
                ->pluck('language_code');
            DB::commit();
            return response()->json([
                'message' => 'Success',
                'id' => $menu_id_used,
                'code' => $languageList
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'error' => 'Error when storing data! ' . $th->getMessage()
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

            //only shows remaining languages
            $usedLang = MenuNavigationTranslation::where('menu_id', $data->menu_id)
                ->where('menu_translation_id', '!=', $id)
                ->pluck('language_code');
            $lang = AppLanguage::pluck('code');
            $remainingLang = $lang->diff($usedLang);
            // $remainingLang->prepend($data->language_code);
            // dd($remainingLang);
            $languages = AppLanguage::whereIn('code', $remainingLang)
                ->select('code as value', 'name as label')->get();

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

    public function destroy(String $id)
    {
        try {
            //code...
            DB::beginTransaction();
            $deleteMenuNavigationTranslation = MenuNavigationTranslation::where('menu_translation_id', $id);
            $getMenuNav = $deleteMenuNavigationTranslation->first();
            $sumOfMenuNavTrans = MenuNavigationTranslation::where('menu_id', $getMenuNav->menu_id)->count();

            $deleteMenuNavigationTranslation->delete();
            if ($sumOfMenuNavTrans == 1) {
                $deleteMenuNavigation = MenuNavigation::where('menu_id', $getMenuNav->menu_id);
                $deleteMenuNavigation->delete();
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
