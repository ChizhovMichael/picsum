<?php

namespace App\Providers;

use App\Contracts\PhotoContract;
use App\Contracts\PhotoIntegrationContract;
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
        $this->app->singleton(PhotoIntegrationContract::class, function ($app) {
            return new PhotoIntegrationService(
                config('api.api_v2_picsum'),
                $app->make(Http::class)
            );
        });
        $this->app->bind(PhotoContract::class, PhotoService::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [PhotoIntegrationContract::class];
    }
}
