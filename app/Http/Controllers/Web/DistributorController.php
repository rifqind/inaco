<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use App\Models\InternationalMarket;
use App\Models\PageTranslation;
use App\Models\SubpageTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class DistributorController extends Controller
{
    //
    public function index()
    {
        $code = 'id';
        $data = $this->distributorGenerate($code);
        return view('web.distributor', [
            'distributor' => $data['distributor'],
            'bigCity' => $data['bigCity'],
            'page' => $data['page'],
            'code' => $code,
            'section' => $data['section'],
            'indonesiaISO' => $data['indonesiaISO']
        ]);
    }

    public function distributor(Request $request, string $code = null)
    {
        $code ??= 'id';
        if ($code == 'id') {
            return redirect()->route('web.id.distributor');
        }
        $data = $this->distributorGenerate($code);
        return view('web.distributor', [
            'distributor' => $data['distributor'],
            'bigCity' => $data['bigCity'],
            'page' => $data['page'],
            'code' => $code,
            'section' => $data['section'],
            'indonesiaISO' => $data['indonesiaISO']
        ]);
    }


    private function distributorGenerate(string $code = null)
    {
        $page = PageTranslation::where('language_code', $code)
            ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
            ->where('pages_slug', 'distributor')
            ->where('pages_status', 1)
            ->first();

        $section = $page ? SubpageTranslation::where('language_code', $code)
            ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
            ->where('sub_pages_slug', 'like', 'bagian-%')
            ->where('sb.pages_id', $page->pages_id)
            ->where('sb.sub_pages_status', 1)
            ->get() : collect([]);

        $distributor = Distributor::join('ref_province as rp', 'rp.id', '=', 'distributor.province')
            // ->join('ref_city as rc', 'rc.id', '=', 'distributor.city')
            ->select([
                'distributor.province',
                'rp.name as province_name',
                'rp.iso as iso'
            ])->distinct();
        $distributorList = $distributor->get();
        $indonesiaISO = $distributor->pluck('iso');
        $bigCity = null;
        $data = [];
        $data['indonesiaISO'] = $indonesiaISO;
        $data['distributor'] = $distributorList;
        $data['bigCity'] = $bigCity;
        $data['page'] = $page;
        $data['section'] = $section;
        return $data;
    }

    public function Intermarket(Request $request, string $code = null)
    {
        $code ??= 'id';
        if ($code == 'id') {
            return redirect()->route('web.id.intermarket');
        }
        $data = $this->marketGenerate($code);
        return view('web.intermarket', [
            'code' => $code,
            'market' => $data['market'],
            'northAmerica' => $data['northAmerica'],
            'southAmerica' => $data['southAmerica'],
            'europe' => $data['europe'],
            'africa' => $data['africa'],
            'asia' => $data['asia'],
            'oceania' => $data['oceania'],
            'countryISO' => $data['countryISO'],
            'page' => $data['page'],
            'section' => $data['section'],
        ]);
    }

    public function intermarketInd()
    {
        $code = 'id';
        $data = $this->marketGenerate($code);
        return view('web.intermarket', [
            'code' => $code,
            'market' => $data['market'],
            'northAmerica' => $data['northAmerica'],
            'southAmerica' => $data['southAmerica'],
            'europe' => $data['europe'],
            'africa' => $data['africa'],
            'asia' => $data['asia'],
            'oceania' => $data['oceania'],
            'countryISO' => $data['countryISO'],
            'page' => $data['page'],
            'section' => $data['section'],
        ]);
    }

    private function marketGenerate(string $code)
    {
        $page = PageTranslation::where('language_code', $code)
            ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
            ->where('pages_slug', 'pasar-internasional')
            ->where('pages_status', 1)
            ->first();

        $section = $page ? SubpageTranslation::where('language_code', $code)
            ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
            ->where('sub_pages_slug', 'like', 'bagian-%')
            ->where('sb.pages_id', $page->pages_id)
            ->where('sb.sub_pages_status', 1)
            ->get() : collect([]);

        $market = InternationalMarket::join('ref_country as rc', 'rc.id', '=', 'international_market.country')
            ->select('rc.iso', 'rc.continent', 'rc.name')
            ->distinct()
            ->get();

        $countryISO = $market->pluck('iso')->unique();
        $northAmerica = $market->filter(fn($item) => $item->continent === 'North America');
        $southAmerica = $market->filter(fn($item) => $item->continent === 'South America');
        $europe = $market->filter(fn($item) => $item->continent === 'Europe');
        $africa = $market->filter(fn($item) => $item->continent === 'Africa');
        $asia = $market->filter(fn($item) => $item->continent === 'Asia');
        $oceania = $market->filter(fn($item) => $item->continent === 'Oceania');

        $data = [];
        $data['market'] = $market;
        $data['northAmerica'] = $northAmerica;
        $data['southAmerica'] = $southAmerica;
        $data['europe'] = $europe;
        $data['africa'] = $africa;
        $data['asia'] = $asia;
        $data['oceania'] = $oceania;
        $data['countryISO'] = $countryISO;
        $data['page'] = $page;
        $data['section'] = $section;
        return $data;
    }
   

    private function formatDescription($description)
    {
        $cleanText = strip_tags(html_entity_decode($description));
        $words = explode(' ', $cleanText);

        return count($words) > 17
            ? implode(' ', array_slice($words, 0, 17)) . '...'
            : $cleanText;
    }

    private function formatDate($date)
    {
        return date('d M Y', strtotime($date));
    }
}
