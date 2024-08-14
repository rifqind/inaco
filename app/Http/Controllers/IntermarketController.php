<?php

namespace App\Http\Controllers;

use App\Models\InternationalMarket;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntermarketController extends Controller
{
    //
    public function index()
    {
        $query = InternationalMarket::query();
        $query->join('ref_country as rcountry', 'rcountry.id', '=', 'international_market.country');
        $query->join('products as p', 'p.product_id', '=', 'international_market.product_export');
        $query->select([
            'international_market.market_id',
            'rcountry.nicename as country_name',
            'p.product_id'
        ]);

        $data = $query->get();
        // dd($data);
        foreach ($data as $key => $value) {
            # code...
            //search available languague, english is priority
            $getData = ProductTranslation::where('product_id', $value->product_id)->get();

            //check if language with code en exists if isnt exist get first row
            $translation = $getData->firstWhere('language_code', 'en');
            if (!$translation) $translation = $getData->first();

            $product_export = $translation->product_title . ' (' . $translation->language_code . ')';
            $value->product_export = $product_export;
        }
        return view('cms.intermarket.list_intermarket', [
            'data' => $data
        ]);
    }

    public function create()
    {
        $product = Product::get();
        $list = [];
        foreach ($product as $key => $value) {
            # code...
            $check = ProductTranslation::where('product_id', $value->product_id)->count();
            if ($check > 1) {
                $checkLvl2 = ProductTranslation::where('product_id', $value->product_id)
                    ->where('language_code', 'en')->first();
                if ($checkLvl2) array_push($list, $checkLvl2->product_translation_id);
                else {
                    $checkLvl2 = ProductTranslation::where('product_id', $value->product_id)->first();
                    array_push($list, $checkLvl2->product_translation_id);
                }
            } else {
                $check = ProductTranslation::where('product_id', $value->product_id)->first();
                array_push($list, $check->product_translation_id);
            }
        }
        // dd($list);
        $product = ProductTranslation::select(['product_id as value', 'product_title as label', 'language_code'])
            ->whereIn('product_translation_id', $list)
            ->get();
        foreach ($product as $key => $value) {
            # code...
            $value->label = $value->label . ' (' . $value->language_code . ')';
        }
        $country = DB::table('ref_country')->select(['id as value', 'nicename as label'])->get();
        return view('cms.intermarket.create_intermarket', [
            'product' => $product,
            'country' => $country
        ]);
    }

    public function store(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $data = $request->validate([
                'country' => ['required', 'integer'],
                'product_export' => ['required', 'integer']
            ]);
            $insertIntermarket = InternationalMarket::create($data);
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
            $product = Product::get();
            $list = [];
            foreach ($product as $key => $value) {
                # code...
                $check = ProductTranslation::where('product_id', $value->product_id)->count();
                if ($check > 1) {
                    $checkLvl2 = ProductTranslation::where('product_id', $value->product_id)
                        ->where('language_code', 'en')->first();
                    if ($checkLvl2) array_push($list, $checkLvl2->product_translation_id);
                    else {
                        $checkLvl2 = ProductTranslation::where('product_id', $value->product_id)->first();
                        array_push($list, $checkLvl2->product_translation_id);
                    }
                } else {
                    $check = ProductTranslation::where('product_id', $value->product_id)->first();
                    array_push($list, $check->product_translation_id);
                }
            }
            // dd($list);
            $product = ProductTranslation::select(['product_id as value', 'product_title as label', 'language_code'])
                ->whereIn('product_translation_id', $list)
                ->get();
            foreach ($product as $key => $value) {
                # code...
                $value->label = $value->label . ' (' . $value->language_code . ')';
            }
            $country = DB::table('ref_country')->select(['id as value', 'nicename as label'])->get();
            $data = InternationalMarket::where('market_id', $id)->first();
            return view('cms.intermarket.update_intermarket', [
                'data' => $data,
                'country' => $country,
                'product' => $product
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'market_id' => ['required', 'integer'],
                    'country' => ['required', 'integer'],
                    'product_export' => ['required', 'integer']
                ]);
                $updateIntermarket = InternationalMarket::where('market_id', $data['market_id'])->update($data);
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
            $deleteIntermarket = InternationalMarket::where('market_id', $id)->delete();
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
