<?php

declare(strict_types=1);

namespace App\Services;

use App\Constants\NewsDataSource;
use Illuminate\Support\Facades\App;

class NewsServiceFactory
{
    public static function build(NewsDataSource $source): NewsService
    {
        return match($source) {
            NewsDataSource::NewsApi => App::make(NewsApiService::class),
            NewsDataSource::TheGuardian => App::make(TheGuardianService::class),
            NewsDataSource::TheNewYorkTimes => App::make(TheNewYorkTimesService::class),
        };
    }
}
