<?php

namespace App\Providers;

use App\Http\View\Composers\CtaComposer;
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
    }
}
