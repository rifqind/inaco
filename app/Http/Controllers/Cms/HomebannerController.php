<?php

namespace App\Http\Cms\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use App\Models\Homebanner;
use App\Models\HomebannerTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class HomebannerController extends Controller
{
    //
    public function index()
    {
        $query = HomebannerTranslation::query();
        $query->join('homebanner as h', 'h.banner_id', '=', 'homebanner_translation.banner_id');
        $query->join('app_language as al', 'al.code', '=', 'homebanner_translation.language_code');
        $query->select([
            'homebanner_translation.*',
            'h.banner_name',
            'h.banner_image',
            'al.name as language_name'
        ]);

        $data = $query->get();
        foreach ($data as $key => $value) {
            # code...
            $text = $value->banner_caption;
            $cleanText = strip_tags($text);
            $words = explode(' ', $cleanText);

            // Check if the word count is greater than 10
            if (count($words) > 10) {
                $firstTenWords = implode(' ', array_slice($words, 0, 10));
                $value->banner_caption = $firstTenWords . '...';
            } else {
                $value->banner_caption = $cleanText;
            }
            $languageList = HomebannerTranslation::where('banner_id', $value->banner_id)->pluck('language_code');
            $value->languageList = $languageList;
        }
        return view('cms.banner.list_homebanner', [
            'data' => $data
        ]);
    }

    public function create(Request $request)
    {
        $languages = AppLanguage::select('code as value', 'name as label')->get();
        if ($request) {
            $data = Homebanner::where('banner_id', $request->banner_id)->first();
            if ($data) {
                $pageTitleList = HomebannerTranslation::where('homebanner_translation.banner_id', $data->banner_id)
                    ->join('homebanner', 'homebanner.banner_id', '=', 'homebanner_translation.banner_id')
                    ->get(['banner_name', 'language_code']);
                foreach ($pageTitleList as $key => $value) {
                    # code...
                    $value->titles = $value->banner_name . ' (' . $value->language_code . ')';
                }
                $titles = $pageTitleList->pluck('titles');
                $data->language_code = $pageTitleList->pluck('language_code');
                return view('cms.banner.create_homebanner', [
                    'languages' => $languages,
                    'data' => $data,
                    'titles' => $titles
                ]);
            }
        }
        $data = new Homebanner();
        $fillable = $data->getFillable();
        foreach ($fillable as $key) {
            $data->$key = null;
        }
        $data->banner_id = null;
        $data->language_code = null;
        return view('cms.banner.create_homebanner', [
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
                'banner_id' => ['sometimes', 'integer'],
                'banner_name' => ['required', 'string', 'max:50'],
                'banner_caption' => ['required', 'string', 'max:200'],
                'language_code' => ['required', 'string'],
                'banner_status' => ['required', 'integer'],
                'banner_url' => ['required', 'string'],
                // 'pages_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
            ]);
            $banner_id_used = null;
            if ($request->banner_id) {
                $data['banner_image'] = $request->validate([
                    'banner_image' => 'required',
                ]);
                $insertBannerTranslation = HomebannerTranslation::create([
                    'banner_id' => $data['banner_id'],
                    'language_code' => $data['language_code'],
                    'banner_caption' => $data['banner_caption'],
                    'banner_url' => $data['banner_url'],
                ]);
                $banner_id_used = $data['banner_id'];
            } else {
                $data['banner_image'] = $request->validate([
                    'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
                ]);
                if ($request->hasFile('banner_image')) {
                    $file = $request->file('banner_image');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/banner/' . $fileName;

                    $insertBanner = Homebanner::create([
                        'banner_name' => $data['banner_name'],
                        'banner_image' => $fileName,
                        'banner_status' => $data['banner_status'],
                    ]);
                    $insertBannerTranslation = HomebannerTranslation::create([
                        'banner_id' => $insertBanner->banner_id,
                        'language_code' => $data['language_code'],
                        'banner_caption' => $data['banner_caption'],
                        'banner_url' => $data['banner_url'],
                    ]);
                    $file->move(public_path('data/banner'), $fileName);
                    $banner_id_used = $insertBanner->banner_id;
                }
            }
            $languageList = HomebannerTranslation::where('banner_id', $banner_id_used)
                ->pluck('language_code');
            DB::commit();
            return response()->json([
                'message' => 'Success',
                'id' => $banner_id_used,
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
            $query = HomebannerTranslation::query();
            $query->join('homebanner as h', 'h.banner_id', '=', 'homebanner_translation.banner_Id');
            $query->where('banner_translation_id', $id)
                ->select([
                    'homebanner_translation.*',
                    'h.banner_name',
                    'h.banner_image',
                    'h.banner_status'
                ]);
            $data = $query->first();

            //only show remaining languages
            $usedLang = HomebannerTranslation::where('banner_id', $data->banner_id)
                ->where('banner_translation_id', '!=', $id)
                ->pluck('language_code');
            $lang = AppLanguage::pluck('code');
            $remainingLang = $lang->diff($usedLang);
            $languages = AppLanguage::whereIn('code', $remainingLang)
                ->select('code as value', 'name as label')
                ->get();
            return view('cms.banner.update_banner', [
                'languages' => $languages,
                'data' => $data
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'banner_translation_id' => ['required', 'integer'],
                    'banner_name' => ['required', 'string', 'max:50'],
                    'banner_caption' => ['required', 'string'],
                    'language_code' => ['required', 'string'],
                    'banner_status' => ['required', 'integer'],
                    'banner_url' => ['required', 'string'],
                    'banner_image_update' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5048',
                ]);

                $updateBannerTranslation = HomebannerTranslation::where('banner_translation_id', $data['banner_translation_id']);
                $updateBannerTranslation->update([
                    'language_code' => $data['language_code'],
                    'banner_caption' => $data['banner_caption'],
                    'banner_url' => $data['banner_url'],
                ]);
                $getBanner = $updateBannerTranslation->value('banner_id');
                $updateBanner = Homebanner::where('banner_id', $getBanner);
                $updateBanner->update([
                    'banner_status' => $data['banner_status'],
                    'banner_name' => $data['banner_name']
                ]);

                if ($request->hasFile('banner_image_update')) {
                    $file = $request->file('banner_image_update');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/banner/' . $fileName;

                    $getFileName = $updateBanner->value('banner_image');
                    $updateBanner->update([
                        'banner_image' => $fileName
                    ]);

                    //update file 
                    $file->move(public_path('data/banner'), $fileName);
                    //previous path & delete it
                    $getFilePath = 'data/banner/' . $getFileName;

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
            $deleteBannerTranslation = HomebannerTranslation::where('banner_translation_id', $id);
            $getBanner = $deleteBannerTranslation->first();
            $sum = HomebannerTranslation::where('banner_id', $getBanner->banner_id)->count();

            $deleteBannerTranslation->delete();
            if ($sum == 1) {
                $deleteBanner = Homebanner::where('banner_id', $getBanner->banner_id);
                $fileName = $deleteBanner->first();
                $filePath = 'data/banner/' . $fileName->banner_image;
                if (isset($filePath) && File::exists(public_path($filePath))) {
                    File::delete(public_path($filePath));
                }
                $deleteBanner->delete();
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
