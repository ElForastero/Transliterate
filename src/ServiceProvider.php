<?php

namespace ElForastero\Transliterate;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider.
 *
 * @author Eugene Dzhumak <elforastero@ya.ru>
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $configPath = __DIR__.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'transliterate.php';

        $this->publishes([
            $configPath => config_path('transliterate.php'),
        ]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $configPath = __DIR__.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'transliterate.php';

        $this->mergeConfigFrom($configPath, 'transliterate');

        $this->app->bind('Transliterator', function ($app) {
            return new Transliterator();
        });
    }
}
