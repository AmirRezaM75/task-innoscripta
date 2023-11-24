<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\NewsSearchQuery;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class NewsApiHttpService
{
    private PendingRequest $client;

    public function __construct(private readonly string $token)
    {
        $this->client = Http::baseUrl('https://newsapi.org/v2/')
            ->withHeaders([
                'X-Api-Key' => $this->token
            ]);
    }

    /**
     * @link https://newsapi.org/docs/endpoints/everything
     */
    public function search(NewsSearchQuery $query): Response
    {
        return $this->client
            ->get('everything', [
                'from' => $query->from->toDateString(),
                'to' => $query->to->toDateString(),
                // NewsApi has a bug when using pageSize and page combination:
                // You have requested too many results. Developer accounts are limited to a max of 100 results.
                // You are trying to request results 150 to 200. Please upgrade to a paid plan if you need more results.
                // 'pageSize' => $query->pageSize,
                'page' => $query->page,
                'sortBy' => 'publishedAt',
                'sources' => $query->getSources()
            ]);
    }

    public function sources(): Response
    {
        return $this->client->get('top-headlines/sources');
    }
}
