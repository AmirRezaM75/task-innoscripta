<?php

declare(strict_types=1);

namespace App\Actions;

use App\Constants\NewsDataSource;
use App\DataTransferObjects\NewsSearchQuery;
use App\Jobs\ImportNewsSearchResultArticle;
use App\Services\NewsServiceFactory;
use Illuminate\Support\Carbon;

class ImportTheNewYorkTimesArticles
{
    public function execute(Carbon $from, Carbon $to): void
    {
        $page = 0;

        do {
            $query = new NewsSearchQuery(NewsDataSource::TheNewYorkTimes, $from, $to, $page, pageSize: 30);

            $response = NewsServiceFactory::build($query->dataSource)->search($query);

            foreach ($response->articles as $article) {
                ImportNewsSearchResultArticle::dispatch($article);
            }

            $page++;
        } while($response->hasNextPage);
    }
}
