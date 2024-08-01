<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
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
    public function index()
    {
        $query = SubpageTranslation::query();
        $query->join('sub_pages as sp', 'sp.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id');
        $query->join('app_language as al', 'al.code', '=', 'sub_pages_translation.language_code');
        $query->join('pages_translation as p', 'p.pages_id', '=', 'sp.pages_id');
        $query->select([
            'sub_pages_translation_id as id', 'p.pages_title', 'sub_pages_title', 'sub_pages_description', 'al.name as language_name'
        ]);

        //sementara
        $data = $query->get();
        return view('cms.subpages.list_subpage', [
            'data' => $data
        ]);
    }

    public function create()
    {
        $languages = AppLanguage::select('code as value', 'name as label')->get();
        $pages = PageTranslation::select('pages_id as value', 'pages_title as label')->get();
        return view('cms.subpages.create_subpage', [
            'languages' => $languages,
            'pages' => $pages
        ]);
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $data = $request->validate([
                'pages_id' => ['required', 'integer'],
                'sub_pages_title' => ['required', 'string', 'max:100'],
                'sub_pages_description' => ['required', 'string'],
                'language_code' => ['required', 'string'],
                'sub_pages_status' => ['required', 'integer'],
                'sub_pages_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
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
                $sub_pages_slug = Str::slug($data['sub_pages_title'], '-');
                $insertSubpageTranslation = SubpageTranslation::create([
                    'sub_pages_id' => $insertSubpage->sub_pages_id,
                    'language_code' => $data['language_code'],
                    'sub_pages_title' => $data['sub_pages_title'],
                    'sub_pages_description' => $data['sub_pages_description'],
                    'sub_pages_slug' => $sub_pages_slug,
                ]);
                $file->move(public_path('data/subpages'), $fileName);
                DB::commit();
                return response()->json([
                    'message' => 'Success'
                ]);
            }
            DB::commit();
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
            $languages = AppLanguage::select('code as value', 'name as label')->get();
            $pages = PageTranslation::select('pages_id as value', 'pages_title as label')->get();
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
                'data' => $data
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
                    'sub_pages_image_update' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5048',
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

    public function destroy(String $id)
    {
        try {
            //code...
            DB::beginTransaction();
            $deleteSubpageTranslation = SubpageTranslation::where('sub_pages_translation_id', $id);
            $getPage = $deleteSubpageTranslation->value('sub_pages_id');
            $deletePage = Subpage::where('sub_pages_id', $getPage);

            $deleteSubpageTranslation->delete();
            $deletePage->delete();

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
