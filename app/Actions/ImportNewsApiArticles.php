<?php

declare(strict_types=1);

namespace App\Actions;

use App\Constants\NewsDataSource;
use App\DataTransferObjects\NewsSearchQuery;
use App\Exceptions\MaximumResultsReachedException;
use App\Jobs\ImportNewsArticleResult;
use App\Repository\NewsApiSourceRepository;
use App\Services\NewsServiceFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ImportNewsApiArticles
{
    public function __construct(
        private readonly NewsApiSourceRepository $newsApiSourceRepository
    ) {
    }

    public function execute(Carbon $from, Carbon $to): void
    {
        // NewsApi doesn't allow us to search when query is too broad
        // Thus we narrow the results by adding 'sources' query to mitigate following error:
        // > Required parameters are missing, the scope of your search is too broad.
        // > Please set any of the following required parameters and try again: q, qInTitle, sources, domains.
        $offset = 0;
        $limit = 20; // Max allowed values for 'sources' is 20

        do {
            $sources = $this->newsApiSourceRepository
                ->get($limit, $offset)
                ->pluck('external_id')
                ->all();

            $page = 1;

            do {
                $query = new NewsSearchQuery(NewsDataSource::NewsApi, $from, $to, $page);
                $query->setSources($sources);

                try {
                    $response = NewsServiceFactory::build($query->dataSource)->search($query);
                } catch (MaximumResultsReachedException $e) {
                    Log::error($e->getMessage());
                    break;
                }

                foreach ($response->articles as $article) {
                    ImportNewsArticleResult::dispatch($article);
                }

                $page++;
            } while($response->hasNextPage);


            $offset += $limit;
        } while(count($sources) === $limit);
    }
}
