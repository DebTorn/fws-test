<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceLayerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Services\Interfaces\IProductService::class,
            \App\Services\ProductService::class
        );
        $this->app->bind(
            \App\Services\Interfaces\ICategoryService::class,
            \App\Services\CategoryService::class
        );

        $this->app->bind(
            \App\Services\Interfaces\IDocumentService::class,
            \App\Services\DocumentService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
