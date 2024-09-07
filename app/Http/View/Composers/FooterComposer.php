<?php

namespace App\Http\View\Composers;

use App\Models\AppLanguage;
use App\Models\ProductCategoryTranslation;
use Illuminate\View\View;

class FooterComposer
{
    public function compose(View $view)
    {
        $lang = request()->route('code');
        if (!$lang) $lang = 'id';
        $view->with([
            'code' => $lang
        ]);
    }
}
