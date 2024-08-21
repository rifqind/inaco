<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\PageTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PageController extends Controller
{
    //
    public function index()
    {
        $query = PageTranslation::query();
        $query->join('pages as p', 'p.pages_id', '=', 'pages_translation.pages_id');
        $query->join('app_language as al', 'al.code', '=', 'pages_translation.language_code');
        $query->select([
            'pages_translation_id as id',
            'p.pages_id',
            'pages_title',
            'pages_description',
            'al.name as language_name'
        ]);

        //sementara
        $data = $query->get();
        foreach ($data as $key => $value) {
            # code...
            $text = $value->pages_description;
            $cleanText = strip_tags($text);
            $cleanText = html_entity_decode($cleanText);
            $words = explode(' ', $cleanText);

            // Check if the word count is greater than 10
            if (count($words) > 10) {
                $firstTenWords = implode(' ', array_slice($words, 0, 10));
                $value->pages_description = $firstTenWords . '...';
            } else {
                $value->pages_description = $cleanText;
            }

            $languageList = PageTranslation::where('pages_id', $value->pages_id)->pluck('language_code');
            $value->languageList = $languageList;
        }
        return view('cms.pages.list_page', [
            'data' => $data
        ]);
    }

    public function create(Request $request)
    {
        $languages = AppLanguage::select('code as value', 'name as label')->get();
        if ($request) {
            $data = Page::where('pages_id', $request->pages_id)->first();
            if ($data) {
                $pageTitleList = PageTranslation::where('pages_id', $data->pages_id)
                    ->get(['pages_title', 'language_code']);
                foreach ($pageTitleList as $key => $value) {
                    # code...
                    $value->titles = $value->pages_title . ' (' . $value->language_code . ')';
                }
                $titles = $pageTitleList->pluck('titles');
                $data->language_code = $pageTitleList->pluck('language_code');
                return view('cms.pages.create_page', [
                    'languages' => $languages,
                    'data' => $data,
                    'titles' => $titles
                ]);
            }
        }
        $data = new Page();
        $fillable = $data->getFillable();
        foreach ($fillable as $key) {
            $data->$key = null;
        }
        $data->pages_id = null;
        $data->language_code = null;
        return view('cms.pages.create_page', [
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
                'pages_id' => ['sometimes', 'integer'],
                'pages_title' => ['required', 'string', 'max:100'],
                'pages_description' => ['required', 'string'],
                'language_code' => ['required', 'string'],
                'pages_status' => ['required', 'integer'],
                // 'pages_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
            ]);
            $pages_id_used = null;
            $pages_slug = Str::slug($data['pages_title'], '-');
            if ($request->pages_id) {
                $data['pages_image'] = $request->validate([
                    'pages_image' => 'required',
                ]);
                $insertPageTranslation = PageTranslation::create([
                    'pages_id' => $data['pages_id'],
                    'language_code' => $data['language_code'],
                    'pages_title' => $data['pages_title'],
                    'pages_description' => $data['pages_description'],
                    'pages_slug' => $pages_slug,
                ]);
                $pages_id_used = $data['pages_id'];
            } else {
                $data['pages_image'] = $request->validate([
                    'pages_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
                ]);
                if ($request->hasFile('pages_image')) {
                    $file = $request->file('pages_image');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/pages/' . $fileName;

                    $insertPage = Page::create([
                        'create_date' => date('Y-m-d H:i:s'),
                        'pages_image' => $fileName,
                        'pages_status' => $data['pages_status']
                    ]);
                    $insertPageTranslation = PageTranslation::create([
                        'pages_id' => $insertPage->pages_id,
                        'language_code' => $data['language_code'],
                        'pages_title' => $data['pages_title'],
                        'pages_description' => $data['pages_description'],
                        'pages_slug' => $pages_slug,
                    ]);
                    $file->move(public_path('data/pages'), $fileName);
                    $pages_id_used = $insertPage->pages_id;
                }
            }
            $languageList = PageTranslation::where('pages_id', $pages_id_used)
                ->pluck('language_code');
            DB::commit();
            return response()->json([
                'message' => 'Success',
                'id' => $pages_id_used,
                'code' => $languageList
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            if (isset($filePath) && File::exists(public_path($filePath))) {
                File::delete(public_path($filePath));
            }
            return response()->json([
                'error' => 'Error when storing data! ' . $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, String $id = null)
    {
        if ($request->isMethod('get')) {
            $query = PageTranslation::query();
            $query->join('pages as p', 'p.pages_id', '=', 'pages_translation.pages_id');
            $query->where('pages_translation_id', $id)
                ->select([
                    'pages_translation_id as id',
                    'p.pages_id',
                    'pages_description',
                    'language_code',
                    'pages_image',
                    'pages_status',
                    'pages_title'
                ]);
            $data = $query->first();

            //only show remaining languages
            $usedLang = PageTranslation::where('pages_id', $data->pages_id)
                ->where('pages_translation_id', '!=', $id)
                ->pluck('language_code');
            $lang = AppLanguage::pluck('code');
            $remainingLang = $lang->diff($usedLang);
            $languages = AppLanguage::whereIn('code', $remainingLang)
                ->select('code as value', 'name as label')
                ->get();
            return view('cms.pages.update_page', [
                'languages' => $languages,
                'data' => $data
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'pages_translation_id' => ['required', 'integer'],
                    'pages_title' => ['required', 'string', 'max:100'],
                    'pages_description' => ['required', 'string'],
                    'language_code' => ['required', 'string'],
                    'pages_status' => ['required', 'integer'],
                    'pages_image_update' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5048',
                ]);

                $updatePageTranslation = PageTranslation::where('pages_translation_id', $data['pages_translation_id']);
                $pages_slug = Str::slug($data['pages_title'], '-');
                $updatePageTranslation->update([
                    'language_code' => $data['language_code'],
                    'pages_title' => $data['pages_title'],
                    'pages_description' => $data['pages_description'],
                    'pages_slug' => $pages_slug,
                ]);
                $getPages = $updatePageTranslation->value('pages_id');
                $updatePage = Page::where('pages_id', $getPages);
                $updatePage->update([
                    'pages_status' => $data['pages_status']
                ]);

                if ($request->hasFile('pages_image_update')) {
                    $file = $request->file('pages_image_update');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/pages/' . $fileName;

                    $getFileName = $updatePage->value('pages_image');
                    $updatePage->update([
                        'pages_image' => $fileName
                    ]);

                    //update file 
                    $file->move(public_path('data/pages'), $fileName);
                    //previous path & delete it
                    $getFilePath = 'data/pages/' . $getFileName;

                    if (isset($getFilePath) && File::exists(public_path($getFilePath))) {
                        File::delete(public_path($getFilePath));
                    }
                }
                DB::commit();
                return response()->json([
                    'message' => 'Success',
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                if (isset($filePath) && File::exists(public_path($filePath))) {
                    File::delete(public_path($filePath));
                }
                return response()->json([
                    'error' => 'Error updating data! ' . $th->getMessage()
                ]);
            }
        }
    }

    public function destroy(String $id)
    {
        try {
            //code...
            DB::beginTransaction();
            $deletePageTranslation = PageTranslation::where('pages_translation_id', $id);
            $getPage = $deletePageTranslation->first();
            $sumOfPageTrans = PageTranslation::where('pages_id', $getPage->pages_id)->count();

            $deletePageTranslation->delete();
            if ($sumOfPageTrans == 1) {
                $deletePage = Page::where('pages_id', $getPage->pages_id);
                $fileName = $deletePage->first();
                $filePath = 'data/pages/' . $fileName->pages_image;
                if (isset($filePath) && File::exists(public_path($filePath))) {
                    File::delete(public_path($filePath));
                }
                $deletePage->delete();
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
