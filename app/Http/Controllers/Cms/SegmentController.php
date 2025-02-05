<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\ProductSegment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SegmentController extends Controller
{
    //
    public function index()
    {
        $data = ProductSegment::get();
        return view('cms.segment.list_segment', [
            'data' => $data
        ]);
    }

    public function create(Request $request)
    {
        return view('cms.segment.create_segment');
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $data = $request->validate([
                'segment_name' => 'string|max:50|required|unique:product_segment,segment_name',
                'segment_name_non_id' => 'string|max:50|required|unique:product_segment,segment_name_non_id',
                'segment_description' => 'string|max:200|required',
            ]);
            ProductSegment::create($data);
            DB::commit();
            return response()->json(['message' => 'Success']);
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
            $data = ProductSegment::where('segment_id', $id)->first();
            return view('cms.segment.update_segment', [
                'data' => $data
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'segment_id' => 'required',
                    'segment_name' => ['string', 'max:50', 'required', Rule::unique('product_segment')->ignore($id)],
                    'segment_name_non_id' => ['string', 'max:50', 'required', Rule::unique('product_segment')->ignore($id)],
                    'segment_description' => ['string', 'max:200', 'required'],
                ]);
                $test = ProductSegment::where('segment_id', $data['segment_id']);
                // dd($test);
                $test->update([
                    'segment_name' => $data['segment_name'],
                    'segment_name_non_id' => $data['segment_name_non_id'],
                    'segment_description' => $data['segment_description'],
                ]);
                DB::commit();
                return response()->json(['message' => 'Success']);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    'error' => 'Error when storing data! ' . $th->getMessage()
                ]);
            }
        }
    }

    public function destroy(String $id)
    {
        try {
            //code...
            DB::beginTransaction();
            $deleteSegment = ProductSegment::where('segment_id', $id);
            $deleteSegment->delete();
            DB::commit();
            return response()->json(['message' => 'Successfully deleted']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'error' => 'Error while deleting ' . $th->getMessage()
            ]);
        }
    }
}
