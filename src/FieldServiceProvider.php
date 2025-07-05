<?php

namespace Laradrax\Fields;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Nova::serving(function (ServingNova $event): void {
            Nova::mix('text-mask', __DIR__.'/../dist/mix-manifest.json');
        });
        $this->loadJsonTranslationsFrom(__DIR__.'/../lang');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
