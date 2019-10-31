<?php

namespace LaMomo\Providers;

use Illuminate\Support\ServiceProvider;
use LaMomo\Support\Remittances;
use LaMomo\Support\Disbursements;
use LaMomo\Support\Collection;
use LaMomo\Console\Commands\MomoCollections;
use LaMomo\Console\Commands\MomoDisbursents;
use LaMomo\Console\Commands\MomoRemittances;
use LaMomo\Console\Commands\MomoInitialization;

class MomoProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMomoSdkService();
        if ($this->app->runningInConsole()) {
            $this->registerResources();
        }
        if ($this->isLumen() === false) {
            $this->mergeConfigFrom(__DIR__ . '/config/momosdk.php', 'momosdk');
        }
    }
    /**
     * Register resources.
     *
     * @return void
     */
    public function registerResources()
    {
        if ($this->isLumen() === false) {
            $this->publishes([
                __DIR__ . '/config/momosdk.php' => config_path('momosdk.php'),
            ], 'config');
        }
    }
    /**
     * Register momo provider.
     *
     * @return void
     */
    public function registerMomoSdkService()
    {
        $this->app->alias('momo_collections', Collection::class);
        $this->app->alias('momo_remittances', Remittances::class);
        $this->app->alias('momo_remittances', Disbursements::class);
        $this->app->singleton('momo_collections', function ($app) {
            return new Collection($app['cache']);
        });
        $this->app->singleton('momo_remittances', function ($app) {
            return new Remittances($app['cache']);
        });
        $this->app->singleton('momo_disbursements', function ($app) {
            return new Disbursements($app['cache']);
        });
    }
    public function boot()
    {
        $this->registerCommands();
    }
    /**
     * Check if package is running under Lumen app
     *
     * @return bool
     */
    protected function isLumen()
    {
        return str_contains($this->app->version(), 'Lumen') === true;
    }
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MomoCollections::class,
                MomoDisbursents::class,
                MomoRemittances::class,
                MomoInitialization::class,
            ]);
        }
    }
}
