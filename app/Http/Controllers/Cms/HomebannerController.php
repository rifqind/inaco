<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use App\Models\Homebanner;
use App\Models\HomebannerTranslation;
use App\Models\ProductSegment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;

class HomebannerController extends Controller
{
    //
    public function index()
    {
        $query = HomebannerTranslation::query();
        $query->join('homebanner as h', 'h.banner_id', '=', 'homebanner_translation.banner_id');
        $query->join('app_language as al', 'al.code', '=', 'homebanner_translation.language_code');
        $query->leftjoin('product_segment as ps', 'ps.segment_id', '=', 'h.segment_id');
        $query->select([
            'homebanner_translation.*',
            'h.banner_name',
            'h.banner_image',
            'h.display_sequence',
            'ps.segment_name',
            'ps.segment_name_non_id',
            'al.name as language_name'
        ]);

        $data = $query->get();
        foreach ($data as $key => $value) {
            # code...
            $text = $value->banner_caption;
            $cleanText = strip_tags($text);
            $cleanText = html_entity_decode($cleanText);
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
        $segments = ProductSegment::select('segment_id as value', 'segment_name as label')->get();
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
                    'titles' => $titles,
                    'segments' => $segments,
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
            'data' => $data,
            'segments' => $segments,
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
                'banner_url' => ['sometimes', 'nullable', 'string'],
                'display_sequence' => ['required', 'integer'],
                'segment_id' => ['sometimes', 'nullable'],
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
                    'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif',
                ]);
                if ($request->hasFile('banner_image')) {
                    $file = $request->file('banner_image');
                    $imageDimensions = getimagesize($file);
                    // Check if the image dimensions are at least 1900x1072
                    if ($imageDimensions[0] < 1900 || $imageDimensions[1] < 1072) {
                        // return back()->withErrors(['banner_image' => 'The image must be at least 1900x1072 pixels.']);
                        return response()->json([
                            'error' => 'The image must be at least 1900x1072 pixels.'
                        ]);
                    }
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/banner/' . $fileName;
                    $image = Image::read($file->path());
                    $resizedImage = $image->resize(1900, 1072, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $insertBanner = Homebanner::create([
                        'banner_name' => $data['banner_name'],
                        'banner_image' => $fileName,
                        'banner_status' => $data['banner_status'],
                        'display_sequence' => $data['display_sequence'],
                        'segment_id' => $request->segment_id ?  $data['segment_id'] : null,
                    ]);
                    $insertBannerTranslation = HomebannerTranslation::create([
                        'banner_id' => $insertBanner->banner_id,
                        'language_code' => $data['language_code'],
                        'banner_caption' => $data['banner_caption'],
                        'banner_url' => $data['banner_url'],
                    ]);
                    // $file->move(public_path('data/banner'), $fileName);
                    // dd(public_path('data/banner'));
                    $quality = 100;
                    $resizedImage->save(public_path('data/banner') . '/' . $fileName, $quality);
                    while (filesize(public_path('data/banner') . '/' . $fileName) > 600 * 1024) {
                        $quality -= 5;
                        $resizedImage->save(public_path('data/banner') . '/' . $fileName, $quality);
                        if ($quality <= 10)
                            break;
                    }
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

    public function update(Request $request, string $id = null)
    {
        if ($request->isMethod('get')) {
            $query = HomebannerTranslation::query();
            $query->join('homebanner as h', 'h.banner_id', '=', 'homebanner_translation.banner_Id');
            $query->where('banner_translation_id', $id)
                ->select([
                    'homebanner_translation.*',
                    'h.banner_name',
                    'h.banner_image',
                    'h.banner_status',
                    'h.display_sequence',
                    'h.segment_id'
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
            $segments = ProductSegment::select('segment_id as value', 'segment_name as label')->get();
            return view('cms.banner.update_banner', [
                'languages' => $languages,
                'data' => $data,
                'segments' => $segments,
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
                    'banner_url' => ['sometimes', 'nullable', 'string'],
                    'display_sequence' => ['required', 'integer'],
                    'segment_id' => ['sometimes', 'nullable'],
                    'banner_image_update' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
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
                    'banner_name' => $data['banner_name'],
                    'display_sequence' => $data['display_sequence'],
                    'segment_id' => $request->segment_id ? $data['segment_id'] : null,
                ]);

                if ($request->hasFile('banner_image_update')) {
                    $file = $request->file('banner_image_update');
                    $imageDimensions = getimagesize($file);
                    // Check if the image dimensions are at least 1900x1072
                    if ($imageDimensions[0] < 1900 || $imageDimensions[1] < 1072) {
                        // return back()->withErrors(['banner_image' => 'The image must be at least 1900x1072 pixels.']);
                        return response()->json([
                            'error' => 'The image must be at least 1900x1072 pixels.'
                        ]);
                    }
                    // Resize the image if it's larger than the required dimensions
                    $image = Image::read($file->path());
                    $resizedImage = $image->resize(1900, 1072, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/banner/' . $fileName;

                    $getFileName = $updateBanner->value('banner_image');
                    $updateBanner->update([
                        'banner_image' => $fileName
                    ]);

                    //update file 
                    // $file->move(public_path('data/banner'), $fileName);
                    // $resizedImage->save(public_path('data/banner') . '/' . $fileName);
                    $quality = 100;
                    $resizedImage->save(public_path('data/banner') . '/' . $fileName, $quality);
                    while (filesize(public_path('data/banner') . '/' . $fileName) > 400 * 1024) {
                        $quality -= 5;
                        $resizedImage->save(public_path('data/banner') . '/' . $fileName, $quality);
                        if ($quality <= 10)
                            break;
                    }
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

    public function destroy(string $id)
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
