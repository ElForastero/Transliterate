<?php

namespace ElForastero\Transliterate;

use Illuminate\Support\ServiceProvider;

class TransliterationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Transliteration', function ($app) {
            return new Transliteration();
        });
    }
}