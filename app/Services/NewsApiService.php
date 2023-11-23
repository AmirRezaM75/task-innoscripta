<?php

namespace App\Services;

use App\DataTransferObjects\NewsSearchQuery;
use App\DataTransferObjects\NewsSearchResult;
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
                $article['title'],
                $article['description'],
                $article['author'],
                $article['source'],
                $article['publishedAt'],
            );
        }

        return $items;
    }
}
