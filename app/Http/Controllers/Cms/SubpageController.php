<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Subpage;
use App\Models\SubpageTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SubpageController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = SubpageTranslation::query();
        $query->join('sub_pages as sp', 'sp.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id');
        $query->join('app_language as al', 'al.code', '=', 'sub_pages_translation.language_code');
        $query->join('pages as p', 'p.pages_id', '=', 'sp.pages_id');
        $query->select([
            'sub_pages_translation_id as id',
            'p.pages_id',
            'sp.sub_pages_id',
            'sub_pages_title',
            'sub_pages_description',
            'al.name as language_name'
        ]);

        $is_slugged = false;
        $pages_slug = false;
        $pgcontent = false;
        $is_pgcontent = false;
        if ($request->pages_slug) {
            $query->join('pages_translation as pt', 'pt.pages_id', '=', 'sp.pages_id')
                ->where('sp.pages_id', $request->pages_slug);
            //    ->where('pt.pages_slug', $request->pages_slug);
            $query->distinct();
            $is_slugged = true;
            $pages_slug = $request->pages_slug;
        }


        //sementara
        // dd($query->toSql());
        $data = $query->get();
        // dd($data);
        foreach ($data as $key => $value) {
            # code...

            # code...
            $text = $value->sub_pages_description;
            $cleanText = strip_tags($text);
            $cleanText = html_entity_decode($cleanText);
            $words = explode(' ', $cleanText);

            // Check if the word count is greater than 10
            if (count($words) > 10) {
                $firstTenWords = implode(' ', array_slice($words, 0, 10));
                $value->sub_pages_description = $firstTenWords . '...';
            } else {
                $value->sub_pages_description = $cleanText;
            }

            //search available languague, english is priority
            $getData = PageTranslation::where('pages_id', $value->pages_id)->get();

            //check if language with code en exists if isnt exist get first row
            $translation = $getData->firstWhere('language_code', 'en');
            if (!$translation)
                $translation = $getData->first();

            $pages_title = $translation->pages_title;
            $value->pages_title = $pages_title;
            $languageList = PageTranslation::where('pages_id', $value->pages_id)->pluck('language_code');
            $value->languageList = $languageList;
        }


        if($request->pgcontent){
            $is_pgcontent = true;
            $pgcontent = $request->pgcontent;
            $query = PageTranslation::query();
             $query->join('pages as p', 'p.pages_id', '=', 'pages_translation.pages_id');
            $query->join('app_language as al', 'al.code', '=', 'pages_translation.language_code');
            $query->where('p.pages_id', $request->pages_slug);
            $query->select([
              'pages_translation_id as id',
               'p.pages_id',
              'pages_title',
             'pages_description',
             'al.name as language_name'
            ]);

         //sementara
            $data_page = $query->get();
            foreach ($data_page as $key => $value) {
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
        }else
            $data_page = $is_pgcontent;


        return view('cms.subpages.list_subpage', [
            'data_page' => $data_page,
            'data' => $data,
            'is_slugged' => $is_slugged,
            'pages_slug' => $pages_slug,
            'is_pgcontent' => $is_pgcontent,
            'pgcontent' => $pgcontent
        ]);
    }

    public function create(Request $request)
    {
        $languages = AppLanguage::select('code as value', 'name as label')->get();
        $pages = Page::get();
        $list = [];
        $is_slugged = false;
        if ($request->is_slugged)
            $is_slugged = $request->is_slugged;
        foreach ($pages as $key => $value) {
            # code...
            $check = PageTranslation::where('pages_id', $value->pages_id)->count();
            if ($check > 1) {
                $checkLvl2 = PageTranslation::where('pages_id', $value->pages_id)
                    ->where('language_code', 'en')->first();
                if ($checkLvl2)
                    array_push($list, $checkLvl2->pages_translation_id);
                else {
                    $checkLvl2 = PageTranslation::where('pages_id', $value->pages_id)->first();
                    array_push($list, $checkLvl2->pages_translation_id);
                }
            } else {
                $check = PageTranslation::where('pages_id', $value->pages_id)->first();
                array_push($list, $check->pages_translation_id);
            }
        }
        $pages = PageTranslation::select('pages_id as value', 'pages_title as label', 'language_code')
            ->whereIn('pages_translation_id', $list)
            ->get();
        if ($request) {
            $data = Subpage::where('sub_pages_id', $request->sub_pages_id)->first();
            if ($data) {
                $subpageTitleList = SubpageTranslation::where('sub_pages_id', $data->sub_pages_id)
                    ->get(['sub_pages_title', 'language_code']);
                foreach ($subpageTitleList as $key => $value) {
                    # code...
                    $value->titles = $value->sub_pages_title;
                }
                $titles = $subpageTitleList->pluck('titles');
                $data->language_code = $subpageTitleList->pluck('language_code');
                return view('cms.subpages.create_subpage', [
                    'languages' => $languages,
                    'pages' => $pages,
                    'data' => $data,
                    'titles' => $titles,
                    'is_slugged' => $is_slugged
                ]);
            }
        }
        $data = new Subpage();
        $fillable = $data->getFillable();
        foreach ($fillable as $key) {
            $data->$key = null;
        }
        $data->sub_pages_id = null;
        $data->language_code = null;

        return view('cms.subpages.create_subpage', [
            'languages' => $languages,
            'pages' => $pages,
            'data' => $data,
            'is_slugged' => $is_slugged
        ]);
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $data = $request->validate([
                'sub_pages_id' => ['sometimes', 'integer'],
                'pages_id' => ['required', 'integer'],
                'sub_pages_title' => ['required', 'string', 'max:100'],
                'sub_pages_description' => ['required', 'string'],
                'language_code' => ['required', 'string'],
                'sub_pages_status' => ['required', 'integer'],
            ]);
            $sub_pages_id_used = null;
            $sub_pages_slug = Str::slug($data['sub_pages_title'], '-');
            if ($request->sub_pages_id) {
                $data['sub_pages_image'] = $request->validate([
                    'sub_pages_image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
                ]);
                $insertSubpageTranslation = SubpageTranslation::create([
                    'sub_pages_id' => $data['sub_pages_id'],
                    'language_code' => $data['language_code'],
                    'sub_pages_title' => $data['sub_pages_title'],
                    'sub_pages_description' => $data['sub_pages_description'],
                    'sub_pages_slug' => $sub_pages_slug,
                ]);
                $sub_pages_id_used = $data['sub_pages_id'];
            } else {
                $data['sub_pages_image'] = $request->validate([
                    'sub_pages_image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
                ]);
                if ($request->hasFile('sub_pages_image')) {
                    $file = $request->file('sub_pages_image');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/subpages/' . $fileName;
                    $insertSubpage = Subpage::create([
                        'create_date' => date('Y-m-d H:i:s'),
                        'pages_id' => $data['pages_id'],
                        'sub_pages_image' => $fileName,
                        'sub_pages_status' => $data['sub_pages_status']
                    ]);
                    $insertSubpageTranslation = SubpageTranslation::create([
                        'sub_pages_id' => $insertSubpage->sub_pages_id,
                        'language_code' => $data['language_code'],
                        'sub_pages_title' => $data['sub_pages_title'],
                        'sub_pages_description' => $data['sub_pages_description'],
                        'sub_pages_slug' => $sub_pages_slug,
                    ]);
                    $file->move(public_path('data/subpages'), $fileName);
                
                }else{
                    $insertSubpage = Subpage::create([
                        'create_date' => date('Y-m-d H:i:s'),
                        'pages_id' => $data['pages_id'],
                        'sub_pages_status' => $data['sub_pages_status']
                    ]);
                    $insertSubpageTranslation = SubpageTranslation::create([
                        'sub_pages_id' => $insertSubpage->sub_pages_id,
                        'language_code' => $data['language_code'],
                        'sub_pages_title' => $data['sub_pages_title'],
                        'sub_pages_description' => $data['sub_pages_description'],
                        'sub_pages_slug' => $sub_pages_slug,
                    ]);
                }

                $sub_pages_id_used = $insertSubpage->sub_pages_id;
            }

            $languageList = PageTranslation::where('pages_id', $sub_pages_id_used)
                ->pluck('language_code');
            DB::commit();
            return response()->json([
                'message' => 'Success',
                'id' => $sub_pages_id_used,
                'code' => $languageList
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            if (isset($filePath) && File::exists(public_path($filePath))) {
                File::delete(public_path($filePath));
            }
            return response()->json([
                'error' => 'Error when storing data! ' . $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, string $id = null)
    {
        if ($request->isMethod('get')) {
            $languages = AppLanguage::select('code as value', 'name as label')->get();
            $pages = Page::get();
            $list = [];
            $is_slugged = false;
            if ($request->is_slugged)
                $is_slugged = $request->is_slugged;
            foreach ($pages as $key => $value) {
                # code...
                $check = PageTranslation::where('pages_id', $value->pages_id)->count();
                if ($check > 1) {
                    $checkLvl2 = PageTranslation::where('pages_id', $value->pages_id)
                        ->where('language_code', 'en')->first();
                    if ($checkLvl2)
                        array_push($list, $checkLvl2->pages_translation_id);
                    else {
                        $checkLvl2 = PageTranslation::where('pages_id', $value->pages_id)->first();
                        array_push($list, $checkLvl2->pages_translation_id);
                    }
                } else {
                    $check = PageTranslation::where('pages_id', $value->pages_id)->first();
                    array_push($list, $check->pages_translation_id);
                }
            }
            $pages = PageTranslation::select('pages_id as value', 'pages_title as label')
                ->whereIn('pages_translation_id', $list)
                ->get();
            $query = SubpageTranslation::query();
            $query->join('sub_pages as sp', 'sp.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id');
            $query->where('sub_pages_translation_id', $id)
                ->select([
                    'sub_pages_translation_id as id',
                    'sp.pages_id',
                    'sub_pages_description',
                    'language_code',
                    'sub_pages_image',
                    'sub_pages_status',
                    'sub_pages_title'
                ]);
            $data = $query->first();
            return view('cms.subpages.update_subpage', [
                'languages' => $languages,
                'pages' => $pages,
                'data' => $data,
                'is_slugged' => $is_slugged
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'sub_pages_translation_id' => ['required', 'integer'],
                    'pages_id' => ['required', 'integer'],
                    'sub_pages_title' => ['required', 'string', 'max:100'],
                    'sub_pages_description' => ['required', 'string'],
                    'language_code' => ['required', 'string'],
                    'sub_pages_status' => ['required', 'integer'],
                    'sub_pages_image_update' => 'sometimes|image|mimes:jpeg,png,jpg',
                ]);

                $updateSubpageTranslation = SubpageTranslation::where('sub_pages_translation_id', $data['sub_pages_translation_id']);
                $sub_pages_slug = Str::slug($data['sub_pages_title'], '-');
                $updateSubpageTranslation->update([
                    'language_code' => $data['language_code'],
                    'sub_pages_title' => $data['sub_pages_title'],
                    'sub_pages_description' => $data['sub_pages_description'],
                    'sub_pages_slug' => $sub_pages_slug,
                ]);
                $getSubpages = $updateSubpageTranslation->value('sub_pages_id');
                $updateSubpage = Subpage::where('sub_pages_id', $getSubpages);
                $updateSubpage->update([
                    'pages_id' => $data['pages_id'],
                    'sub_pages_status' => $data['sub_pages_status']
                ]);

                if ($request->hasFile('sub_pages_image_update')) {
                    $file = $request->file('sub_pages_image_update');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/subpages/' . $fileName;

                    $getFileName = $updateSubpage->value('sub_pages_image');
                    $updateSubpage->update([
                        'sub_pages_image' => $fileName
                    ]);

                    //update file 
                    $file->move(public_path('data/subpages'), $fileName);
                    //previous path & delete it
                    $getFilePath = 'data/subpages/' . $getFileName;

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

    public function destroy(string $id)
    {
        try {
            //code...
            DB::beginTransaction();
            $deleteSubpageTranslation = SubpageTranslation::where('sub_pages_translation_id', $id);
            $getPage = $deleteSubpageTranslation->first();

            $sumOfSubpageTrans = SubpageTranslation::where('sub_pages_id', $getPage->sub_pages_id)->count();
            $deleteSubpageTranslation->delete();
            if ($sumOfSubpageTrans == 1) {
                $deletePage = Subpage::where('sub_pages_id', $getPage->sub_pages_id);
                $fileName = $deletePage->first();
                $filePath = 'data/subpages/' . $fileName->sub_pages_image;
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
