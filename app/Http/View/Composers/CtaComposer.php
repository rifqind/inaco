<?php

namespace App\Http\View\Composers;

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
        $view->with([
            'segment' => $segment,
            'arabic' => $arabic,
        ]);
    }
}
