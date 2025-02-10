<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\PageTranslation;
use App\Models\Summernote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use DOMDocument;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    //
    public function index(Request $request)
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

        $is_slugged = false;
        $pages_slug = false;
        if ($request->pages_slug) {
            $query->where('pages_slug', $request->pages_slug);
            $query->distinct();
            $is_slugged = true;
            $pages_slug = $request->pages_slug;
        }
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
            'data' => $data,
            'is_slugged' => $is_slugged,
            'pages_slug' => $pages_slug,
        ]);
    }

    public function create(Request $request)
    {
        $languages = AppLanguage::select('code as value', 'name as label')->get();
        $is_slugged = false;
        if ($request->is_slugged)
            $is_slugged = $request->is_slugged;
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
                    'titles' => $titles,
                    'is_slugged' => $is_slugged
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
                'pages_id' => ['sometimes', 'integer'],
                'pages_title' => ['required', 'string', 'max:100'],
                'pages_description' => ['required', 'string'],
                'language_code' => ['required', 'string'],
                'pages_status' => ['required', 'integer'],
            ]);
            $pages_id_used = null;
            $pages_slug = Str::slug($data['pages_title'], '-');
            if ($request->pages_id) {
                $data['pages_image'] = $request->validate([
                    'pages_image' => 'required',
                ]);
                $content = str_replace('src="/temp/', 'src="/image/', $data['pages_description']);
                $insertPageTranslation = PageTranslation::create([
                    'pages_id' => $data['pages_id'],
                    'language_code' => $data['language_code'],
                    'pages_title' => $data['pages_title'],
                    'pages_description' => $content,
                    'pages_slug' => $pages_slug,
                ]);
                $pages_id_used = $data['pages_id'];
                $smnoteimg = $request->summernoteImg;
                if ($smnoteimg) {
                    $filePath = 'image/summernote';
                    if (!File::exists(public_path($filePath))) {
                        File::makeDirectory(public_path($filePath), 0777, true);
                    }
                    foreach ($smnoteimg as $value) {
                        $exploded = explode('/', $value);
                        $find_summernote = Summernote::where('pages_id', $pages_id_used)->where('file_name', $exploded[3])->first();
                        if (!$find_summernote) {
                            Summernote::create([
                                'pages_id' => $pages_id_used,
                                'file_name' => $exploded[3]
                            ]);
                        }
                        File::move(public_path($value), public_path($filePath) . '/' . $exploded[3]);
                    }
                }
            } else {
                $data['pages_image'] = $request->validate([
                    'pages_image' => 'required|image|mimes:jpeg,png,jpg,gif',
                ]);
                if ($request->hasFile('pages_image')) {
                    $file = $request->file('pages_image');
                    $imageDimensions = getimagesize($file);
                    if ($imageDimensions[0] < 1440 || $imageDimensions[1] < 392) {
                        // return back()->withErrors(['banner_image' => 'The image must be at least 545x307 pixels.']);
                        return response()->json([
                            'error' => 'The image must be at least 1440x392 pixels.'
                        ]);
                    }
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/pages/' . $fileName;
                    $image = Image::read($file->path());
                    $resizedImage = $image->resize(1440, 392, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $insertPage = Page::create([
                        'create_date' => date('Y-m-d H:i:s'),
                        'pages_image' => $fileName,
                        'pages_status' => $data['pages_status']
                    ]);
                    $content = str_replace('src="/temp/', 'src="/image/', $data['pages_description']);
                    $insertPageTranslation = PageTranslation::create([
                        'pages_id' => $insertPage->pages_id,
                        'language_code' => $data['language_code'],
                        'pages_title' => $data['pages_title'],
                        'pages_description' => $content,
                        'pages_slug' => $pages_slug,
                    ]);
                    // $file->move(public_path('data/pages'), $fileName);
                    $quality = 100;
                    $resizedImage->save(public_path('data/pages') . '/' . $fileName, $quality);
                    while (filesize(public_path('data/pages') . '/' . $fileName) > 400 * 1024) {
                        $quality -= 5;
                        $resizedImage->save(public_path('data/pages') . '/' . $fileName, $quality);
                        if ($quality <= 10)
                            break;
                    }
                    $pages_id_used = $insertPage->pages_id;
                    $smnoteimg = $request->summernoteImg;
                    if ($smnoteimg) {
                        $filePath = 'image/summernote';
                        if (!File::exists(public_path($filePath))) {
                            File::makeDirectory(public_path($filePath), 0777, true);
                        }
                        foreach ($smnoteimg as $value) {
                            $exploded = explode('/', $value);
                            $find_summernote = Summernote::where('pages_id', $pages_id_used)->where('file_name', $exploded[3])->first();
                            if (!$find_summernote) {
                                Summernote::create([
                                    'pages_id' => $pages_id_used,
                                    'file_name' => $exploded[3]
                                ]);
                            }
                            File::move(public_path($value), public_path($filePath) . '/' . $exploded[3]);
                        }
                    }
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

    public function update(Request $request, string $id = null)
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
            $is_slugged = false;
            if ($request->is_slugged)
                $is_slugged = $request->is_slugged;
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
                'data' => $data,
                'is_slugged' => $is_slugged
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
                    'pages_image_update' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
                ]);

                $updatePageTranslation = PageTranslation::where('pages_translation_id', $data['pages_translation_id']);
                $pages_slug = Str::slug($data['pages_title'], '-');

                // tambahan Upload image in body summereditor, save to server not base64 encode

                /*       $dom = new DomDocument();
              //  $dom->loadHtml($data['pages_description'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $dom->loadHTML(mb_convert_encoding($data['pages_description'], 'HTML-ENTITIES', 'UTF-8'));
                $imageFile = $dom->getElementsByTagName('img');
               
                foreach($imageFile as $item => $image){
                    $dataImg = $image->getAttribute('src');
                    list($type, $dataImg) = explode(';', $dataImg);
                    list(, $dataImg)      = explode(',', $dataImg);

                    if($this->is_base64($dataImg)){
                        $imgeData = base64_decode($dataImg);
                        $image_name= time().$item.'.png';

                        $path = public_path('data/pages') . '/' . $image_name;
                        file_put_contents($path, $imgeData);
                         
                        $image->removeAttribute('src');
                        $image->setAttribute('src', url('data/pages') . '/' . $image_name);//$image_name);
                    }    
                }
               
                $newpages_description = $dom->saveHTML();
                
                //---    
                */
                $content = str_replace('src="/temp/', 'src="/image/', $data['pages_description']);
                $updatePageTranslation->update([
                    'language_code' => $data['language_code'],
                    'pages_title' => $data['pages_title'],
                    'pages_description' => $content,
                    'pages_slug' => $pages_slug,
                ]);
                $getPages = $updatePageTranslation->value('pages_id');
                $updatePage = Page::where('pages_id', $getPages);
                $updatePage->update([
                    'pages_status' => $data['pages_status']
                ]);

                if ($request->hasFile('pages_image_update')) {
                    $file = $request->file('pages_image_update');
                    $imageDimensions = getimagesize($file);
                    if ($imageDimensions[0] < 1440 || $imageDimensions[1] < 392) {
                        // return back()->withErrors(['banner_image' => 'The image must be at least 545x307 pixels.']);
                        return response()->json([
                            'error' => 'The image must be at least 1440x392 pixels.'
                        ]);
                    }
                    $image = Image::read($file->path());
                    $resizedImage = $image->resize(1440, 392, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/pages/' . $fileName;

                    $getFileName = $updatePage->value('pages_image');
                    $updatePage->update([
                        'pages_image' => $fileName
                    ]);

                    //update file 
                    // $file->move(public_path('data/pages'), $fileName);
                    $quality = 100;
                    $resizedImage->save(public_path('data/pages') . '/' . $fileName, $quality);
                    while (filesize(public_path('data/pages') . '/' . $fileName) > 400 * 1024) {
                        $quality -= 5;
                        $resizedImage->save(public_path('data/pages') . '/' . $fileName, $quality);
                        if ($quality <= 10)
                            break;
                    }
                    //previous path & delete it
                    $getFilePath = 'data/pages/' . $getFileName;

                    if (isset($getFilePath) && File::exists(public_path($getFilePath))) {
                        File::delete(public_path($getFilePath));
                    }
                }
                $smnoteimg = $request->summernoteImg;
                if ($smnoteimg) {
                    $filePath = 'image/summernote';
                    if (!File::exists(public_path($filePath))) {
                        File::makeDirectory(public_path($filePath), 0777, true);
                    }
                    foreach ($smnoteimg as $value) {
                        $exploded = explode('/', $value);
                        $find_summernote = Summernote::where('pages_id', $getPages)->where('file_name', $exploded[3])->first();
                        if (!$find_summernote) {
                            Summernote::create([
                                'pages_id' => $getPages,
                                'file_name' => $exploded[3]
                            ]);
                        }
                        File::move(public_path($value), public_path($filePath) . '/' . $exploded[3]);
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
            $deletePageTranslation = PageTranslation::where('pages_translation_id', $id);
            $getPage = $deletePageTranslation->first();
            $sumOfPageTrans = PageTranslation::where('pages_id', $getPage->pages_id)->count();

            $deletePageTranslation->delete();
            if ($sumOfPageTrans == 1) {
                $deletePage = Page::where('pages_id', $getPage->pages_id);
                $findSummernote = Summernote::where('pages_id', $getPage->pages_id)->get();
                if ($findSummernote->isNotEmpty()) {
                    foreach ($findSummernote as $value) {
                        $deletePath = 'image/summernote/' . $value->file_name;
                        if (isset($deletePath) && File::exists(public_path($deletePath))) {
                            File::delete(public_path($deletePath));
                        }
                    }
                    Summernote::where('pages_id', $getPage->pages_id)->delete();
                }
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

    /*
    private function is_base64($s) {
        // Check if there are valid base64 characters
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;

        // Decode the string in strict mode and check the results
        $decoded = base64_decode($s, true);
        if(false === $decoded) return false;

        // Encode the string again
        if(base64_encode($decoded) != $s) return false;

        return true;
    }
  */

    // public function uploadImageSummernote(Request $request, $type)
    // {
    //     $post = $request->all();
    //     $post['type'] = 'summernote';


    //     if ($request->hasFile('pages_image_update')) {
    //                 $file = $request->file('pages_image_update');
    //                 $imageDimensions = getimagesize($file);
    //                 if ($imageDimensions[0] < 1440 || $imageDimensions[1] < 392) {
    //                     // return back()->withErrors(['banner_image' => 'The image must be at least 545x307 pixels.']);
    //                     return response()->json([
    //                         'error' => 'The image must be at least 1440x392 pixels.'
    //                     ]);
    //                 }
    //                 $image = Image::read($file->path());
    //                 $resizedImage = $image->resize(1440, 392, function ($constraint) {
    //                     $constraint->aspectRatio();
    //                     $constraint->upsize();
    //                 });
    //                 $fileName = time() . '_' . $file->getClientOriginalName();
    //                 $filePath = 'data/pages/' . $fileName;

    //                 $getFileName = $updatePage->value('pages_image');
    //                 $updatePage->update([
    //                     'pages_image' => $fileName
    //                 ]);

    //                 //update file 
    //                 // $file->move(public_path('data/pages'), $fileName);
    //                 $quality = 100;
    //                 $resizedImage->save(public_path('data/pages') . '/' . $fileName, $quality);
    //                 while (filesize(public_path('data/pages') . '/' . $fileName) > 400 * 1024) {
    //                     $quality -= 5;
    //                     $resizedImage->save(public_path('data/pages') . '/' . $fileName, $quality);
    //                     if ($quality <= 10)
    //                         break;
    //                 }
    //                 //previous path & delete it
    //                 $getFilePath = 'data/pages/' . $getFileName;

    //                 if (isset($getFilePath) && File::exists(public_path($getFilePath))) {
    //                     File::delete(public_path($getFilePath));
    //                 }
    //             }




    //     // encode image
    //     $size   = $request->file->getSize();
    //     if ($size < 5000000) {
    //         $encoded = base64_encode(fread(fopen($request->file, "r"), filesize($request->file)));
    //     } else {
    //         return ['status' => false, 'messages' => ['Image Size Exceeded 5MB']];
    //     }    
    //     if (!Storage::exists('public/image/' . $post['type'])) {

    //         Storage::makeDirectory('public/image/' . $post['type']);
    //     }

    //     // upload image
    //     $ext = $request->file->getClientOriginalExtension();
    //     $filename = 'summernote_image_' . time() . '.' . $ext;
    //     $img = Image::make($request->file);
    //     $doc_name = 'image/' . $post['type'] . '/' . $filename;
    //     $resource = $img->stream()->detach();
    //     $save = Storage::put('public/' . $doc_name, $resource);
    //     if ($save) {
    //         return [
    //             "status" => "success",
    //             "path" => 'image/' . $post['type'],
    //             "image" => $filename,
    //             "image_url" => Storage::url('image/' . $post['type'] . '/'.$filename)
    //         ];
    //     } else {
    //         return [
    //             "status" => "fail"
    //         ];
    //     }
    // }

    public function uploadSummerNote(Request $request, $type = null)
    {
        $post = $request->all();
        $post['type'] = 'summernote';

        // encode image
        $size   = $request->file->getSize();
        if ($size < 5000000) {
            $encoded = base64_encode(fread(fopen($request->file, "r"), filesize($request->file)));
        } else {
            return ['status' => false, 'messages' => ['Image Size Exceeded 5MB']];
        }
        $filePath = 'temp/' . $post['type'];
        if (!File::exists(public_path($filePath))) {
            File::makeDirectory(public_path($filePath), 0777, true);
        }

        // upload image
        $ext = $request->file->getClientOriginalExtension();
        $name = $request->file->getClientOriginalName();

        $filename = 'summernote_image_' . $name;
        $img = Image::read($request->file->path());
        $doc_name = 'temp/' . $post['type'] . '/' . $filename;
        // $resource = $img->stream()->detach();
        // $save = Storage::put('public/' . $doc_name, $resource);
        $save = $img->save(public_path() . '/' . $doc_name);
        if ($save) {
            return [
                "status" => "success",
                "path" => 'temp/' . $post['type'],
                "image" => $filename,
                "image_url" => '/' . $filePath . '/' . $filename
            ];
        } else {
            return [
                "status" => "fail"
            ];
        }
    }

    public function deleteSummerNote(Request $request, $type = null)
    {
        $arrayUrl = array_filter(explode('/', $request->target));
        $fileName = end($arrayUrl);
        $deleteStorage = File::delete(public_path('temp/summernote/' . $fileName));
        return "success delete";
    }
}
