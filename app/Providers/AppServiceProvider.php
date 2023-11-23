<?php

namespace App\Providers;

use App\Services\NewsApiHttpService;
use App\Services\NewsApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            NewsApiService::class,
            fn() => new NewsApiService(
                new NewsApiHttpService(config('services.news_api.token'))
            )
        );
    }

    public function boot(): void
    {
        //
    }
}
