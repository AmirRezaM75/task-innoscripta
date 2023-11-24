<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repository\ArticleRepository;
use App\Repository\ArticleRepositoryEloquent;
use App\Repository\CategoryRepository;
use App\Repository\CategoryRepositoryEloquent;
use App\Repository\NewsApiSourceRepository;
use App\Repository\NewsApiSourceRepositoryEloquent;
use App\Repository\SourceRepository;
use App\Repository\SourceRepositoryEloquent;
use App\Services\NewsApiHttpService;
use App\Services\NewsApiService;
use App\Services\TheGuardianHttpService;
use App\Services\TheGuardianService;
use App\Services\TheNewYorkTimesHttpService;
use App\Services\TheNewYorkTimesService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ArticleRepository::class,
            ArticleRepositoryEloquent::class
        );

        $this->app->bind(
            CategoryRepository::class,
            CategoryRepositoryEloquent::class
        );

        $this->app->bind(
            NewsApiSourceRepository::class,
            NewsApiSourceRepositoryEloquent::class
        );

        $this->app->bind(
            SourceRepository::class,
            SourceRepositoryEloquent::class
        );

        $this->app->bind(
            NewsApiService::class,
            fn () => new NewsApiService(
                new NewsApiHttpService(config('services.news_api.token')),
                $this->app->make(NewsApiSourceRepository::class)
            )
        );

        $this->app->bind(
            TheGuardianService::class,
            fn () => new TheGuardianService(
                new TheGuardianHttpService(config('services.guardian.token')),
            )
        );

        $this->app->bind(
            TheNewYorkTimesService::class,
            fn () => new TheNewYorkTimesService(
                new TheNewYorkTimesHttpService(config('services.new_york_times.token')),
            )
        );
    }

    public function boot(): void
    {
        //
    }
}
