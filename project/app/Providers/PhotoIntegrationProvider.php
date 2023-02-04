<?php

namespace App\Providers;

use App\Contracts\PhotoIntegrationContract;
use App\Services\PhotoIntegrationService;
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
        $this->app->singleton(PhotoIntegrationContract::class, function () {
            return new PhotoIntegrationService(config('api.api_v2_picsum'), Http::class);
        });
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
