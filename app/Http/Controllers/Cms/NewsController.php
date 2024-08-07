<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use App\Models\News;
use App\Models\NewsTranslation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = NewsTranslation::query();
        $query->where('n.news_category', $request->news_category);
        $query->join('news as n', 'n.news_id', '=', 'news_translation.news_id');
        $query->join('app_language as al', 'al.code', '=', 'news_translation.language_code');
        $query->select([
            'news_translation.news_translation_id as id',
            'n.news_id as news_id',
            'n.create_date',
            'n.news_image',
            'n.news_category',
            'al.name as language_name',
            'al.code as language_code',
            'news_title',
        ]);

        $data = $query->get();
        foreach ($data as $key => $value) {
            # code...
            $languageList = NewsTranslation::where('news_id', $value->news_id)->pluck('language_code');
            $value->languageList = $languageList;
        }
        return view('cms.news.list_news', [
            'data' => $data,
            'category' => $request->news_category
        ]);
    }

    public function create(Request $request)
    {
        $languages = AppLanguage::select('code as value', 'name as label')->get();
        if ($request->news_id) {
            $data = News::where('news_id', $request->news_id)->first();
            if ($data) {
                $newsTitleList = NewsTranslation::where('news_id', $data->news_id)
                    ->get(['news_title', 'language_code']);
                foreach ($newsTitleList as $key => $value) {
                    # code...
                    $value->titles = $value->news_title . ' (' . $value->language_code . ')';
                }
                $titles = $newsTitleList->pluck('titles');
                $data->language_code = $newsTitleList->pluck('language_code');
                return view('cms.news.create_news', [
                    'languages' => $languages,
                    'data' => $data,
                    'titles' => $titles
                ]);
            }
        }
        $data = new News();
        $fillable = $data->getFillable();
        foreach ($fillable as $key) {
            $data->$key = null;
        }
        $data->news_id = null;
        $data->language_code = null;
        return view('cms.news.create_news', [
            'languages' => $languages,
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            // dd($request);
            $data = $request->validate([
                'news_id' => ['sometimes', 'integer'],
                'news_category' => ['required', 'integer'],
                'create_date' => ['required'],
                'news_title' => ['required', 'string', 'max:100'],
                'news_description' => ['required', 'string'],
                'language_code' => ['required', 'string'],
                'news_status' => ['required', 'integer']
            ]);
            $news_id_used = null;
            $news_slug = Str::slug($data['news_title'], '-');
            if ($request->news_id) {
                $data['news_image'] = $request->validate([
                    'news_image' => 'required'
                ]);
                $insertNewsTranslation = NewsTranslation::create([
                    'news_id' => $data['news_id'],
                    'language_code' => $data['language_code'],
                    'news_title' => $data['news_title'],
                    'news_description' => $data['news_description'],
                    'news_slug' => $news_slug,
                ]);
                $news_id_used = $data['news_id'];
            } else {
                $data['news_image'] = $request->validate([
                    'news_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048'
                ]);
                if ($request->hasFile('news_image')) {
                    $file = $request->file('news_image');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/news/' . $fileName;

                    $insertNews = News::create([
                        'create_date' => Carbon::createFromFormat('d/m/Y', $data['create_date'])->format('Y-m-d H:i:s'),
                        'news_image' => $fileName,
                        'news_category' => $data['news_category'],
                        'news_status' => $data['news_status']
                    ]);
                    $insertNewsTranslation = NewsTranslation::create([
                        'news_id' => $insertNews->news_id,
                        'language_code' => $data['language_code'],
                        'news_title' => $data['news_title'],
                        'news_description' => $data['news_description'],
                        'news_slug' => $news_slug,
                    ]);
                    $file->move(public_path('data/news'), $fileName);
                    $news_id_used = $insertNews->news_id;
                }
            }
            $languageList = NewsTranslation::where('news_id', $news_id_used)
                ->pluck('language_code');
            DB::commit();
            return response()->json([
                'message' => 'Success',
                'id' => $news_id_used,
                'code' => $languageList,
                'category' => $data['news_category']
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

    public function update(Request $request, String $id = null)
    {
        if ($request->isMethod('get')) {
            $query = NewsTranslation::query();
            $query->join('news as p', 'p.news_id', '=', 'news_translation.news_id');
            $query->where('news_translation_id', $id)
                ->select([
                    'news_translation_id as id',
                    'p.news_id',
                    'news_category',
                    'create_date',
                    'news_description',
                    'language_code',
                    'news_image',
                    'news_status',
                    'news_title'
                ]);
            $data = $query->first();

            //only show remaining languages
            $usedLang = NewsTranslation::where('news_id', $data->news_id)
                ->where('news_translation_id', '!=', $id)
                ->pluck('language_code');
            $lang = AppLanguage::pluck('code');
            $remainingLang = $lang->diff($usedLang);
            $languages = AppLanguage::whereIn('code', $remainingLang)
                ->select('code as value', 'name as label')
                ->get();
            return view('cms.news.update_news', [
                'languages' => $languages,
                'data' => $data
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'news_translation_id' => ['required', 'integer'],
                    'news_title' => ['required', 'string', 'max:100'],
                    'news_description' => ['required', 'string'],
                    'language_code' => ['required', 'string'],
                    'news_status' => ['required', 'integer'],
                    'news_category' => ['required', 'integer'],
                    'create_date_update' => ['sometimes'],
                    'news_image_update' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5048',
                ]);

                $updateNewsTranslation = NewsTranslation::where('news_translation_id', $data['news_translation_id']);
                $news_slug = Str::slug($data['news_title'], '-');
                $updateNewsTranslation->update([
                    'language_code' => $data['language_code'],
                    'news_title' => $data['news_title'],
                    'news_description' => $data['news_description'],
                    'news_slug' => $news_slug,
                ]);
                $getNews = $updateNewsTranslation->value('news_id');
                $updateNews = News::where('news_id', $getNews);
                $updateNews->update([
                    'news_status' => $data['news_status']
                ]);
                if ($request->create_date_update) {
                    $updateNews->update([
                        'create_date' => Carbon::createFromFormat('d/m/Y', $data['create_date_update'])->format('Y-m-d H:i:s')
                    ]);
                }
                if ($request->hasFile('news_image_update')) {
                    $file = $request->file('news_image_update');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/news/' . $fileName;

                    $getFileName = $updateNews->value('news_image');
                    $updateNews->update([
                        'news_image' => $fileName
                    ]);

                    //update file 
                    $file->move(public_path('data/news'), $fileName);
                    //previous path & delete it
                    $getFilePath = 'data/news/' . $getFileName;

                    if (isset($getFilePath) && File::exists(public_path($getFilePath))) {
                        File::delete(public_path($getFilePath));
                    }
                }
                DB::commit();
                return response()->json([
                    'message' => 'Success',
                    'category' => $data['news_category']
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

    public function destroy(String $id) {
        try {
            //code...
            DB::beginTransaction();
            $deleteNewsTranslation = NewsTranslation::where('news_translation_id', $id);
            $getNews = $deleteNewsTranslation->first();
            $sumOfNewsTrans = NewsTranslation::where('news_id', $getNews->news_id)->count();

            $deleteNewsTranslation->delete();
            if ($sumOfNewsTrans == 1) {
                $deleteNews = News::where('news_id', $getNews->news_id);
                $fileName = $deleteNews->first();
                $filePath = 'data/news/' . $fileName->news_image;
                if (isset($filePath) && File::exists(public_path($filePath))) {
                    File::delete(public_path($filePath));
                }
                $deleteNews->delete();
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
