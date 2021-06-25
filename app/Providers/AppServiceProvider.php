<?php

namespace App\Providers;

use App\Incidence;
use App\News;
use App\Observers\IncidenceObserver;
use App\Observers\NewsObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Incidence::observe(IncidenceObserver::class);
        News::observe(NewsObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
