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
        $arabic = request()->route('code');
        if ($arabic == 'ar') $arabic = true;
        else $arabic = false;
        $socialmedia = OfficialSocmedMarketplace::where('id', 1)
            ->first();
        $view->with([
            'segment' => $segment,
            'arabic' => $arabic,
            'socialmedia' => $socialmedia,
        ]);
    }
}
