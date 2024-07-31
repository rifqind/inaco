<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\SubpageTranslation;
use Illuminate\Http\Request;

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
