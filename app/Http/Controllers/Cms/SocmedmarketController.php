<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\OfficialSocmedMarketplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SocmedmarketController extends Controller
{
    //
    public function index()
    {
        $routeName = Route::currentRouteName();
        $query = OfficialSocmedMarketplace::query();

        if ($routeName == 'socmed-marketplace.social-media.list') {
            $query->select([
                'id',
                'instagram',
                'facebook',
                'tiktok',
                'youtube',
                'twitter',
                'linkedin'
            ]);
        } else if ($routeName == 'socmed-marketplace.marketplace.list') {
            // dd($query);
            $query->select([
                'id',
                'shopee',
                'tokopedia',
                'lazada',
                'tiktokshop'
            ]);
        }

        //sementara
        $data = $query->get();
        // dd($data);
        return view('cms.offsocmedmarket.list_socmed_market', [
            'data' => $data,
            'routeName' => $routeName
        ]);
    }

    public function create()
    {
        return view('cms.offsocmedmarket.create_socmed_market');
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $data = $request->validate([
                'instagram' => ['sometimes', 'nullable', 'string', 'max:60'],
                'facebook' => ['sometimes', 'nullable', 'string', 'max:60'],
                'tiktok' => ['sometimes', 'nullable', 'string', 'max:60'],
                'youtube' => ['sometimes', 'nullable', 'string', 'max:60'],
                'twitter' => ['sometimes', 'nullable', 'string', 'max:60'],
                'shopee' => ['sometimes', 'nullable', 'string', 'max:60'],
                'tokopedia' => ['sometimes', 'nullable', 'string', 'max:60'],
                'lazada' => ['sometimes', 'nullable', 'string', 'max:60'],
                'tiktokshop' => ['sometimes', 'nullable', 'string', 'max:60'],
                'linkedin' => ['sometimes', 'nullable', 'string', 'max:60'],
            ]);
            $insertSocmedMarket = OfficialSocmedMarketplace::create($data);

            DB::commit();
            return response()->json([
                'message' => 'Success',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'error' => 'Error when storing data! ' . $th->getMessage(),
            ]);
        }
    }

    public function update(Request $request, String $id = null)
    {
        if ($request->isMethod('get')) {
            $data = OfficialSocmedMarketplace::where('id', $id)->first();
            return view('cms.offsocmedmarket.update_socmed_market', [
                'data' => $data,
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'instagram' => ['sometimes', 'nullable', 'string', 'max:60'],
                    'facebook' => ['sometimes', 'nullable', 'string', 'max:60'],
                    'tiktok' => ['sometimes', 'nullable', 'string', 'max:60'],
                    'youtube' => ['sometimes', 'nullable', 'string', 'max:60'],
                    'twitter' => ['sometimes', 'nullable', 'string', 'max:60'],
                    'shopee' => ['sometimes', 'nullable', 'string', 'max:60'],
                    'tokopedia' => ['sometimes', 'nullable', 'string', 'max:60'],
                    'lazada' => ['sometimes', 'nullable', 'string', 'max:60'],
                    'tiktokshop' => ['sometimes', 'nullable', 'string', 'max:60'],
                    'linkedin' => ['sometimes', 'nullable', 'string', 'max:60'],
                ]);
                $updateSocmedMarket = OfficialSocmedMarketplace::where('id', $request->id)
                    ->update($data);
                DB::commit();
                return response()->json([
                    'message' => 'Success',
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    'error' => 'Error when updating data! ' . $th->getMessage(),
                ]);
            }
        }
    }

    public function destroy(String $id)
    {
        try {
            //code...
            DB::beginTransaction();
            $deleteSocmedMarket = OfficialSocmedMarketplace::where('id', $id)
                ->delete();
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
