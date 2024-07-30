<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use Illuminate\Http\Request;
use App\Models\PageTranslation;

class PageController extends Controller
{
    //
    public function index()
    {
        $query = PageTranslation::query();
        $query->join('pages as p', 'p.pages_id', '=', 'pages_translation.pages_id');
        $query->join('app_language as al', 'al.code', '=', 'pages_translation.language_code');
        $query->select([
            'pages_translation_id as id', 'pages_title', 'pages_description', 'al.name as language_name'
        ]);

        //sementara
        $data = $query->get();
        return view('cms.pages.list_page', [
            'data' => $data
        ]);
    }

    public function create()
    {
        $languages = AppLanguage::select('code as value', 'name as label')->get();
        return view('cms.pages.create_page', [
            'languages' => $languages,
        ]);
    }

    public function store()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}
