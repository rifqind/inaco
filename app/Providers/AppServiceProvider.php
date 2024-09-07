<?php

namespace App\Providers;

use App\Http\View\Composers\CtaComposer;
use App\Http\View\Composers\FooterComposer;
use App\Http\View\Composers\HeaderComposer;
use App\Http\View\Composers\LayoutComposer;
use App\Http\View\Composers\SidebarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('cms.layouts.leftbar', SidebarComposer::class);
        View::composer('web.layouts.cta-footer', CtaComposer::class);
        View::composer('web.layouts.header', HeaderComposer::class);
        View::composer('web.layouts.app', LayoutComposer::class);
        View::composer('web.layouts.header-arabic', HeaderComposer::class);
        View::composer('web.layouts.footer', FooterComposer::class);
    }
}
