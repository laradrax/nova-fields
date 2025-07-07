<?php

namespace Laradrax\Nova\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

/**
 * Service provider for Nova Fields package.
 *
 * Handles the registration and bootstrapping of Nova fields including
 * asset publishing and localization support.
 */
class FieldsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * Registers Nova assets and translations when Nova is being served.
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
     *
     * Currently no services need to be registered.
     */
    public function register(): void
    {
        //
    }
}
