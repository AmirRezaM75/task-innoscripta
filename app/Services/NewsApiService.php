<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\NewsApiSourceResult;
use App\DataTransferObjects\NewsArticleResult;
use App\DataTransferObjects\NewsCategoryResult;
use App\DataTransferObjects\NewsSearchQuery;
use App\DataTransferObjects\NewsSearchResult;
use App\DataTransferObjects\NewsSourceResult;
use App\Exceptions\MaximumResultsReachedException;
use App\Exceptions\NewsApiSourceNotFoundException;
use App\Exceptions\NewsApiSourcesException;
use App\Exceptions\NewsSearchException;
use App\Repository\NewsApiSourceRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewsApiService implements NewsService
{
    public function __construct(
        private readonly NewsApiHttpService $newsApiHttpService,
        private readonly NewsApiSourceRepository $newsApiSourceRepository
    ) {
    }

    public function search(NewsSearchQuery $query): NewsSearchResult
    {
        $response = $this->newsApiHttpService->search($query);

        Log::info(urldecode((string) $response->transferStats?->getEffectiveUri()));

        if ($response->json('code') === 'maximumResultsReached') {
            throw new MaximumResultsReachedException($response->json('message'));
        }

        if ($response->json('status') === 'error') {
            throw new NewsSearchException($response->json('message'));
        }

        $articles = [];

        foreach ($response->json('articles') as $article) {
            $sourceId = data_get($article, 'source.id');

            // Some articles will be removed from NewsApi and as a result source id is null
            // We don't want to store this type of articles into database.
            if ($sourceId === null) {
                continue;
            }

            $source = new NewsSourceResult($sourceId, $article['source']['name']);

            $newsApiSource = $this->newsApiSourceRepository->findByExternalId($sourceId);

            if ($newsApiSource === null) {
                throw new NewsApiSourceNotFoundException("
                    Could not find NewsApiSource by external id $sourceId.
                    You may need to run app:import-news-api-sources command to sync latest changes.
                ");
            }

            $category = new NewsCategoryResult(
                Str::slug($newsApiSource->category),
                $newsApiSource->category,
            );

            // NewsApi not returning any unique id, we could use slugify version of title,
            // but it's not bulletproof if it gets updated.
            $articles[] = new NewsArticleResult(
                $article['url'],
                $article['title'],
                $article['description'],
                Carbon::parse($article['publishedAt']),
                $source,
                $category,
                $article['author'],
            );
        }

        $hasNextPage = $query->page < ceil((int) $response->json('totalResults') / $query->pageSize);

        return new NewsSearchResult($hasNextPage, $articles);
    }

    /**
     * @return NewsApiSourceResult[]
     * @throws NewsApiSourcesException
     */
    public function sources(): array
    {
        $response = $this->newsApiHttpService->sources();

        if ($response->json('status') === 'error') {
            throw new NewsApiSourcesException($response->json('message'));
        }

        $items = [];

        foreach ($response->json('sources') as $source) {
            $items[] = new NewsApiSourceResult(
                $source['id'],
                $source['name'],
                $source['category']
            );
        }

        return $items;
    }
}
