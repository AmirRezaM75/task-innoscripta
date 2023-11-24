<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\NewsArticleResult;
use App\DataTransferObjects\NewsCategoryResult;
use App\DataTransferObjects\NewsSearchQuery;
use App\DataTransferObjects\NewsSearchResult;
use App\DataTransferObjects\NewsSourceResult;
use App\Exceptions\NewsSearchException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class TheGuardianService implements NewsService
{
    public const SOURCE_ID = 'the-guardian';
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
            $source = new NewsSourceResult(
                self::SOURCE_ID,
                self::SOURCE_NAME
            );

            $category = new NewsCategoryResult(
                $article['sectionId'],
                $article['sectionName'],
            );

            $articles[] = new NewsArticleResult(
                $article['id'],
                $article['webTitle'],
                strip_tags($article['fields']['body']),
                Carbon::parse($article['webPublicationDate']),
                $source,
                $category,
            );
        }

        return new NewsSearchResult(count($results), $articles);
    }
}
