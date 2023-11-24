<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\NewsSearchQuery;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class TheNewYorkTimesHttpService
{
    private PendingRequest $client;

    public function __construct(private readonly string $token)
    {
        $this->client = Http::baseUrl('https://api.nytimes.com/svc/search/v2/');
    }

    /**
     * @link https://developer.nytimes.com/docs/articlesearch-product/1/routes/articlesearch.json/get
     * there are two rate limits per API: 500 requests per day and 5 requests per minute.
     */
    public function search(NewsSearchQuery $query): Response
    {
        return $this->client
            ->get('articlesearch.json', [
                'api-key' => $this->token,
                'begin_date' => $query->from->format('Ymd'),
                'end_date' => $query->to->format('Ymd'),
                'page' => $query->page,
                'sort' => 'newest',
            ]);
    }
}
