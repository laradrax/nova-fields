<?php

namespace Laradrax\Nova\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Nova::serving(function (ServingNova $event): void {
            Nova::mix('nova-fields', __DIR__.'/../../dist/mix-manifest.json');
            Nova::translations(__DIR__.'/../../lang/'.app()->getLocale().'.json');
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
