<?php

declare(strict_types=1);

namespace App\Services;

use App\Constants\NewsDataSource;
use App\DataTransferObjects\NewsArticleResult;
use App\DataTransferObjects\NewsCategoryResult;
use App\DataTransferObjects\NewsSearchQuery;
use App\DataTransferObjects\NewsSearchResult;
use App\DataTransferObjects\NewsSourceResult;
use App\Exceptions\NewsSearchException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TheNewYorkTimesService implements NewsService
{
    public const SOURCE_NAME = 'The New York Times';

    public function __construct(
        private readonly TheNewYorkTimesHttpService $theNewYorkTimesHttpService,
    ) {
    }

    public function search(NewsSearchQuery $query): NewsSearchResult
    {
        $response = $this->theNewYorkTimesHttpService->search($query);

        Log::info(urldecode((string) $response->transferStats?->getEffectiveUri()));

        if ($response->status() !== 200) {
            throw new NewsSearchException(
                $response->json('fault.faultstring', ''),
                $response->status()
            );
        }

        $results = [];

        $articles = $response->json('response.docs', []);

        foreach ($articles as $article) {
            $source = new NewsSourceResult(
                NewsDataSource::TheNewYorkTimes->value,
                self::SOURCE_NAME
            );

            $category = new NewsCategoryResult(
                Str::slug($article['section_name']),
                $article['section_name'],
            );

            $results[] = new NewsArticleResult(
                $article['_id'],
                $article['abstract'],
                $article['lead_paragraph'],
                Carbon::parse($article['pub_date']),
                $source,
                $category,
            );
        }

        $hits = max(0, (int) $response->json('response.meta.hits') - 1);

        $hasNextPage = $query->page < intval($hits / 10);

        return new NewsSearchResult($hasNextPage, $results);
    }
}
