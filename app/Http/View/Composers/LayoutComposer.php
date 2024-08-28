<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class LayoutComposer
{
    public function compose(View $view)
    {
        $lang = request()->route('code');
        if (!$lang) $lang = 'id';
        $view->with(['code' => $lang]);
    }
}
