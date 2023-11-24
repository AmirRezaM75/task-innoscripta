<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repository\CategoryRepository;
use App\Repository\CategoryRepositoryEloquent;
use App\Repository\NewsApiSourceRepository;
use App\Repository\NewsApiSourceRepositoryEloquent;
use App\Services\NewsApiHttpService;
use App\Services\NewsApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            NewsApiSourceRepository::class,
            NewsApiSourceRepositoryEloquent::class
        );

        $this->app->bind(
            CategoryRepository::class,
            CategoryRepositoryEloquent::class
        );

        $this->app->bind(
            NewsApiService::class,
            fn () => new NewsApiService(
                new NewsApiHttpService(config('services.news_api.token')),
                $this->app->make(NewsApiSourceRepository::class)
            )
        );
    }

    public function boot(): void
    {
        //
    }
}
