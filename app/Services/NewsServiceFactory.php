<?php

namespace App\Services;

use App\Constants\NewsDataSource;
use Illuminate\Support\Facades\App;

class NewsServiceFactory
{
    public static function build(NewsDataSource $source): NewsService
    {
        return match($source) {
            NewsDataSource::NewsApi => App::make(NewsApiService::class)
        };
    }
}
