<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributorController extends Controller
{
    //
    public function index()
    {
        $query = Distributor::query();
        // $query->join('ref_country as rcountry', 'rcountry.id', '=', 'distributor.country');
        $query->join('ref_province as rp', 'rp.id', '=', 'distributor.province');
        $query->join('ref_city as rcity', 'rcity.id', '=', 'distributor.city');
        // $query->join('ref_district as rd', 'rd.code', '=', 'distributor.district');
        // $query->join('ref_subdistrict as rs', 'rs.code', '=', 'distributor.subdistrict');
        $query->select([
            'distributor.*',
            'rp.name as province_name',
            'rcity.name as city_name'
        ]);

        $data = $query->get();
        // dd($data);
        return view('cms.distributor.list_distributor', [
            'data' => $data
        ]);
    }

    public function create()
    {
        // $country = DB::table('ref_country')->select(['id as value', 'nicename as label'])->get();
        $province = DB::table('ref_province')->select(['id as value', 'name as label', 'code'])->get();
        return view('cms.distributor.create_distributor', [
            'province' => $province,
        ]);
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $data = $request->validate([
                'distributor_name' => ['sometimes', 'max:100'],
                // 'phone' => ['required', 'string', 'max:100'],
                // 'country' => ['required', 'string', 'max:5'],
                'province' => ['required', 'string', 'max:3'],
                'city' => ['required', 'string', 'max:5'],
                'distributor_type' => ['required', 'string', 'max:1'],
                // 'district' => ['sometimes', 'string', 'max:6'],
                // 'subdistrict' => ['sometimes', 'string', 'max:10'],
                // 'address' => ['required', 'string'],
                // 'latitude' => ['required', 'string', 'max:100'],
                // 'longitude' => ['required', 'string', 'max:100']
            ]);
            $insertDistributor = Distributor::create($data);
            DB::commit();
            return response()->json([
                'message' => 'Success'
            ]);
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
            $data = Distributor::where('distributor_id', $id)->first();
            // $country = DB::table('ref_country')->select(['id as value', 'nicename as label'])->get();
            $province = DB::table('ref_province')->select(['id as value', 'name as label', 'code'])->get();

            return view('cms.distributor.update_distributor', [
                // 'country' => $country,
                'province' => $province,
                'data' => $data
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $request->validate(
                    ['distributor_id' => ['required', 'integer'],]
                );
                $data = $request->validate([
                    'distributor_name' => ['sometimes', 'max:100'],
                    // 'phone' => ['required', 'string', 'max:100'],
                    // 'country' => ['required', 'string', 'max:5'],
                    'province' => ['required', 'string', 'max:3'],
                    'city' => ['required', 'string', 'max:5'],
                    'distributor_type' => ['required', 'string', 'max:1'],
                    // 'district' => ['sometimes', 'string', 'max:6'],
                    // 'subdistrict' => ['sometimes', 'string', 'max:10'],
                    // 'address' => ['required', 'string'],
                    // 'latitude' => ['required', 'string', 'max:100'],
                    // 'longitude' => ['required', 'string', 'max:100']
                ]);
                // if ($data['country'] != '100') {
                //     $data['province'] = null;
                //     $data['city'] = null;
                //     $data['district'] = null;
                //     $data['subdistrict'] = null;
                // }
                $updateDistributor = Distributor::where('distributor_id', $request->distributor_id)
                    ->update($data);
                DB::commit();
                return response()->json([
                    'message' => 'Success'
                ]);
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
            $deleteDistributor = Distributor::where('distributor_id', $id);
            $deleteDistributor->delete();
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
