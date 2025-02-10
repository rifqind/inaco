<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PageTranslation;
use App\Models\SubpageTranslation;
use App\Models\OfficialSocmedMarketplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class PageController extends Controller
{

    public function index(Request $request, string $code = null)
    {
        $route = Route::currentRouteName();
        if ($route == 'web.id.profil-perusahaan') {
            $code = 'id';
            // Fetch page details
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('sb.pages_id', 5)    // Content Profil Perusahaan
                ->where('pages_status', 1)
                ->first();

            // Fetch tentang description
            if ($page) {
                $header_description = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_id', 5)    // Header Profile Perusahaan / Tentang
                    ->where('sb.sub_pages_status', 1)
                    ->first();
            }
            // Fetch list of other years (excluding 'tentang-inaco')
            $tentang_list_tahun = collect();  // Initialize empty collection

            if ($page) {
                $tentang_list_tahun = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->where('sb.sub_pages_id', '<>', 5)  // Not Header
                    ->orderBy('sub_pages_title')
                    ->get();
            }
            // Sanitize the page description, if it exists
            // if ($page) {
            //     $page->pages_description = strip_tags(html_entity_decode($page->pages_description));
            // }
            return view('web.about', [
                'page' => $page,
                'code' => $code,
                'descriptions' => $header_description ??= null,
                'list_year' => $tentang_list_tahun ??= collect([]),
            ]);
        } else if ($route == 'web.id.penghargaan') {
            $code = 'id';
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('sb.pages_id', 6)    // Content Penghargaan
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $header_description = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_id', 21)    // Header Penghargaan
                    ->where('sb.sub_pages_status', 1)
                    ->first();
                $award_list = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('pages_id', $page->pages_id)
                    ->where('sb.sub_pages_id', '<>', 21)  // Not Header
                    ->where('sb.sub_pages_status', 1)
                    ->get();
                $award_list = $award_list->map(function ($item) {
                    // Convert sub_pages_description to an integer
                    $item->sub_pages_description = (int) strip_tags(html_entity_decode($item->sub_pages_description));
                    return $item;
                })->sortByDesc('sub_pages_description');
            }

            return view('web.awards', [
                'page' => $page,
                'code' => $code,
                'descriptions' => $header_description ??= null,
                'award_list' => $award_list ??= collect([]),
            ]);
        } else if ($route == 'web.id.karir') {
            $code = 'id';
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('sb.pages_id', 7)    // Content Karir
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $section = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->whereIn('sb.sub_pages_id', [22, 23])  // Header & Content Middle
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->get();
                $rekrutmen_step = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sub_pages_slug', 'like', 'rekrutmen-%')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->get();
            }
            return view('web.careers', [
                'section' => $section ??= collect([]),
                'page' => $page,
                'code' => $code,
                'rekrutmen_step' => $rekrutmen_step ??= collect([]),
            ]);
        } else if ($route == 'web.id.temukan-kami') {
            $code = 'id';
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('sb.pages_id', 8)    // Content Find Us
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $section = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->whereIn('sb.sub_pages_id', [31, 37])  // Header & Hubungi Kami
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->get();
 
                $daftar_kontak = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    -> whereIn('sb.sub_pages_id', [33, 35, 34, 36])  // Alamat, Telp, Email, Fax
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_status', 1)
                    ->get();
            }
            $socialmedia = OfficialSocmedMarketplace::where('id', 1)
                ->first();
            return view('web.find-us', [
                'section' => $section ??= collect([]),
                'page' => $page ??= null,
                'code' => $code,
                // 'kontak' => $kontak ??= null,
                'socialmedia' => $socialmedia ??= null,
                'daftar_kontak' => $daftar_kontak ??= collect([]),
            ]);
        } else if ($route == 'web.id.tur-pabrik') {
            $code = 'id';
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
                ->where('sb.pages_id', 17)    // Content Tur Pabrik
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $header_description = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_id', 49)    // Header Tur Pabrik                   
                    ->where('sb.sub_pages_status', 1)
                    ->first();
            }
            return view('web.factory-tour', [
                'page' => $page ??= null,
                'code' => $code,
                'descriptions' => $header_description ??= null,
            ]);
        } else if ($route == 'web.id.visi-misi') {
            $code = 'id';
            $page = PageTranslation::where('language_code', $code)
                ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
            //    ->where('pages_slug', 'visi-misi')
                ->where('sb.pages_id', 16)    
                ->where('pages_status', 1)
                ->first();
            if ($page) {
                $header_description = SubpageTranslation::where('language_code', $code)
                    ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
                    ->where('sb.pages_id', $page->pages_id)
                    ->where('sb.sub_pages_id', 50)                  // Header Visi Misi
                    ->where('sb.sub_pages_status', 1)
                    ->first();
            }
            return view('web.vision-mission', [
                'page' => $page ??= null,
                'code' => $code,
                'descriptions' => $header_description ??= null,
            ]);
        }
    }


    public function subPages(Request $request, string $code = null)
    {
        $route = Route::currentRouteName();
        $code ??= 'id';
        if ($route == 'web.about') {
            $page = PageTranslation::where('language_code', $code)
                ->where('pages_slug', 'about')
                ->first();
            $page->pages_description = strip_tags(html_entity_decode($page->pages_description));
            return view('web.about', ['page' => $page, 'code' => $code]);
        } else if ($route == 'web.awards')
            return view('web.awards');
        else if ($route == 'web.find-us')
            return view('web.find-us');
    }

    public function view(Request $request, string $id = null)
    {
        if ($id=='') $id=1;

    //    die($id);
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
            $page = $query->first();
            $code = 'id';

            //only show remaining languages
        /*    $usedLang = PageTranslation::where('pages_id', $data->pages_id)
                ->where('pages_translation_id', '!=', $id)
                ->pluck('language_code');
            $lang = AppLanguage::pluck('code');
            $remainingLang = $lang->diff($usedLang);
            $languages = AppLanguage::whereIn('code', $remainingLang)
                ->select('code as value', 'name as label')
                ->get();
            */    
            return view('web.page_default', [
                'page' => $page ??= null,
                'code' => $code,
           //     'descriptions' => $header_description ??= null,
            ]);
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
