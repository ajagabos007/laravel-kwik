<?php

/**
 * @package Ajagabos\Kwik
 */
namespace Ajagabos\Kwik;

use Illuminate\Support\ServiceProvider;


class KwikServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/kwik.php', 'kwik');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePublishing();
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/kwik.php' => config_path('kwik.php'),
        ], 'kwik-config');


        $this->publishes([
            __DIR__.'/../phpunit.xml' => base_path('phpunit.kwik.xml'),
        ], 'kwik-phpunit');

    }
}
