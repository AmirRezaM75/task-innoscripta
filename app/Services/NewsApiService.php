<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\NewsApiSourceResult;
use App\DataTransferObjects\NewsSearchQuery;
use App\DataTransferObjects\NewsSearchResult;
use App\Exceptions\NewsApiSourcesException;
use App\Exceptions\NewsSearchException;

class NewsApiService implements NewsService
{
    public function __construct(private readonly NewsApiHttpService $newsApiHttpService)
    {
    }

    public function search(NewsSearchQuery $query): array
    {
        $response = $this->newsApiHttpService->search($query);

        $items = [];

        if ($response->json('status') === 'error') {
            throw new NewsSearchException($response->json('message'));
        }

        foreach ($response->json('articles') as $article) {
            $items[] = new NewsSearchResult(
                // NewsApi not returning any unique id, we could use slugify version of title,
                // but it's not bulletproof if it gets updated.
                $article['url'],
                $article['title'],
                $article['description'],
                $article['author'],
                $article['source'],
                $article['publishedAt'],
            );
        }

        return $items;
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
