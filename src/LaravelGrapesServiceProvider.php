<?php

namespace MSA\LaravelGrapes;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use MSA\LaravelGrapes\Middleware\HandleInertiaRequests;
use MSA\LaravelGrapes\Interfaces\PageRepositoryInterface;
use MSA\LaravelGrapes\Repositories\PageRepository;
use MSA\LaravelGrapes\Interfaces\BlockRepositoryInterface;
use MSA\LaravelGrapes\Repositories\BlockRepository;

class LaravelGrapesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PageRepositoryInterface::class, PageRepository::class);
        $this->app->bind(BlockRepositoryInterface::class, BlockRepository::class);

        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'lg');
        $this->mergeConfigFrom(__DIR__.'/../config/ziggy.php', 'ziggy');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'lg');

        if ($this->app->runningInConsole()) {

            $this->publishes([

                __DIR__.'/../config/config.php' => config_path('lg.php'),
                __DIR__.'/../resources/assets/js/PageBuilder.js' => base_path('public/js/laravel-grapes.js'),
                __DIR__.'/../resources/assets/css/laravel-grapes.css' => base_path('public/css/laravel-grapes.css'),
                __DIR__.'/../database/migrations/2022_11_27_020138_create_pages_table.php' => database_path('/migrations/'.date('Y_m_d_His', time()).'_create_pages_table.php'),
                __DIR__.'/../database/migrations/2022_12_06_015222_create_custome_blocks_table.php' => database_path('/migrations/'.date('Y_m_d_His', time()).'_create_custome_blocks_table.php'),

            ], '*');
        }
    }

    protected function registerRoutes()
    {
        Route::group($this->routeBuilderConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

        Route::group($this->routeFrontendConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/frontend.php');
        });
    }

    protected function routeBuilderConfiguration()
    {
        return [
            'prefix' => config('lg.builder_prefix'),
            'middleware' => null,
        ];
    }

    protected function routeFrontendConfiguration()
    {
        return [
            'prefix' => config('lg.frontend_prefix'),
            'middleware' => 'web',
        ];
    }
}
