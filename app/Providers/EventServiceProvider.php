<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\ArticleCreated;
use App\Listeners\ImportArticleIntoElastic;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        ArticleCreated::class => [
            ImportArticleIntoElastic::class,
        ],
    ];
}
