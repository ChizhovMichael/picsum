<?php

namespace App\Providers;

use App\Services\PhotoInterface;
use App\Services\PhotoIntegrationInterface;
use App\Services\PhotoIntegrationService;
use App\Services\PhotoService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class PhotoIntegrationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PhotoIntegrationInterface::class, function ($app) {
            return new PhotoIntegrationService(
                config('api.api_v2_picsum'),
                $app->make(Http::class)
            );
        });
        $this->app->bind(PhotoInterface::class, PhotoService::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [PhotoIntegrationInterface::class];
    }
}
