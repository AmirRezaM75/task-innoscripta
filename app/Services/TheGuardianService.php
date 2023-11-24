<?php

declare(strict_types=1);

namespace App\Services;

use App\Constants\NewsDataSource;
use App\DataTransferObjects\NewsSearchQuery;
use App\DataTransferObjects\NewsSearchResult;
use App\DataTransferObjects\NewsSearchResultArticle;
use App\DataTransferObjects\NewsSearchResultCategory;
use App\DataTransferObjects\NewsSearchResultSource;
use App\Exceptions\NewsSearchException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class TheGuardianService implements NewsService
{
    public const SOURCE_NAME = 'The Guardian';

    public function __construct(
        private readonly TheGuardianHttpService $theGuardianHttpService,
    ) {
    }

    public function search(NewsSearchQuery $query): NewsSearchResult
    {
        $response = $this->theGuardianHttpService->search($query);

        Log::info(urldecode((string) $response->transferStats?->getEffectiveUri()));

        if ($response->status() !== 200) {
            throw new NewsSearchException(
                $response->json('response.message', $response->json('message', '')),
                $response->status()
            );
        }

        $articles = [];

        $results = $response->json('response.results', []);

        foreach ($results as $article) {
            $source = new NewsSearchResultSource(
                NewsDataSource::TheGuardian->value,
                self::SOURCE_NAME
            );

            $category = new NewsSearchResultCategory(
                $article['sectionId'],
                $article['sectionName'],
            );

            $articles[] = new NewsSearchResultArticle(
                $article['id'],
                $article['webTitle'],
                strip_tags($article['fields']['body']),
                Carbon::parse($article['webPublicationDate']),
                $source,
                $category,
            );
        }

        $hasNextPage = $query->page < (int) $response->json('response.pages');

        return new NewsSearchResult($hasNextPage, $articles);
    }
}
