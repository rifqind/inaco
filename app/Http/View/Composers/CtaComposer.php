<?php

namespace App\Http\View\Composers;

use App\Models\OfficialSocmedMarketplace;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class CtaComposer
{
    public function compose(View $view)
    {
        $currentRoute = Route::currentRouteName();
        if ($currentRoute == 'web.catalog') {
            $segment = request()->route('id');
        } else {
            $segment = 'not catalog';
        }
        $lang = request()->route('code');
        if (!$lang)
            $lang = 'id';
        $socialmedia = OfficialSocmedMarketplace::where('id', 1)
            ->first();
        $view->with([
            'segment' => $segment,
            'lang' => $lang,
            'socialmedia' => $socialmedia,
        ]);
    }
}
