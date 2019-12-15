<?php

namespace LaMomo\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use LaMomo\Console\Commands\MomoCollections;
use LaMomo\Console\Commands\MomoDisbursents;
use LaMomo\Console\Commands\MomoInitialization;
use LaMomo\Console\Commands\MomoRemittances;
use LaMomo\Contracts\Collections;
use LaMomo\Contracts\Disbursements;
use LaMomo\Contracts\Remittances;
use LaMomo\Support\CollectionService;
use LaMomo\Support\DisbursementsService;
use LaMomo\Support\RemittancesService;

class MomoProvider extends ServiceProvider implements DeferrableProvider
{
    protected $defer = true;
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
        $this->app->singleton(Collections::class, function ($app) {
            return new CollectionService($app['cache']);
        });
        $this->app->singleton(Remittances::class, function ($app) {
            return new RemittancesService($app['cache']);
        });
        $this->app->singleton(Disbursements::class, function ($app) {
            return new DisbursementsService($app['cache']);
        });

        // $this->app->bind(Collections::class, CollectionService::class);
        // $this->app->bind(Remittances::class, RemittancesService::class);
        // $this->app->bind(Disbursements::class, DisbursementsService::class);

        $this->app->alias(Collections::class, CollectionService::class);
        $this->app->alias(Remittances::class, RemittancesService::class);
        $this->app->alias(Disbursements::class, DisbursementsService::class);
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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Collections::class,
            Remittances::class,
            Disbursements::class,
        ];
    }
}
