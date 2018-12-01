<?php

namespace ElForastero\Transliterate;

use Illuminate\Support\ServiceProvider;

/**
 * Class TransliterationServiceProvider
 * @package ElForastero\Transliterate
 * @author Eugene Dzhumak <elforastero@ya.ru>
 * @version 2.0.0
 */
class TransliterationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/transliterate.php' => config_path('transliterate.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/transliterate.php', 'transliterate');

        $this->app->bind('Transliteration', function ($app) {
            return new Transliteration();
        });
    }
}