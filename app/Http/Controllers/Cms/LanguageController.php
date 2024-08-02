<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LanguageController extends Controller
{
    //
    public function index()
    {
        $data = AppLanguage::get();
        return view('cms.language.list_language', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('cms.language.create_language');
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $data = $request->validate([
                'code' => ['required', 'string', 'max:2'],
                'name' => ['required', 'string', 'max:100'],
                'icon_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
            ]);
            if ($request->hasFile('icon_image')) {
                $file = $request->file('icon_image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'data/language/' . $fileName;

                $insertLanguage = AppLanguage::create([
                    'code' => $data['code'],
                    'name' => $data['name'],
                    'icon_image' => $fileName,
                ]);
                $file->move(public_path('data/language'), $fileName);
                DB::commit();
                return response()->json([
                    'message' => 'Success'
                ]);
            }
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
            $data = AppLanguage::where('code', $id)->first();
            return view('cms.language.update_language', ['data' => $data]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'old_code' => ['required', 'string', 'max:2'],
                    'code' => ['required', 'string', 'max:2'],
                    'name' => ['required', 'string', 'max:100'],
                    'icon_image_update' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5048',
                ]);
                $updateLanguage = AppLanguage::where('code', $data['old_code']);
                if ($updateLanguage) {
                    $updateLanguage->update([
                        'code' => $data['code'],
                        'name' => $data['name'],
                    ]);
                }
                if ($request->hasFile('icon_image_update')) {
                    $file = $request->file('icon_image_update');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'data/language/' . $fileName;

                    $getFileName = $updateLanguage->value('icon_image');
                    $updateLanguage->update(['icon_image' => $fileName]);

                    $file->move(public_path('data/language'), $fileName);
                    $getFilePath = 'data/language/' . $getFileName;

                    if (isset($getFilePath) && File::exists(public_path($getFilePath))) {
                        File::delete(public_path($getFilePath));
                    }
                }
                $code = AppLanguage::where('code', $data['code'])->value('code');
                DB::commit();
                return response()->json([
                    'message' => 'Success',
                    'code' => $code,
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
            $deleteLanguage = AppLanguage::where('code', $id)->delete();

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
