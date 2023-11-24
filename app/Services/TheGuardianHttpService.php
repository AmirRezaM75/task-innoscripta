<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\NewsSearchQuery;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class TheGuardianHttpService
{
    private PendingRequest $client;

    public function __construct(private readonly string $token)
    {
        $this->client = Http::baseUrl('https://content.guardianapis.com/');
    }

    /**
     * @link https://open-platform.theguardian.com/documentation/
     */
    public function search(NewsSearchQuery $query): Response
    {
        return $this->client
            ->get('search', [
                'api-key' => $this->token,
                'from-date' => $query->from->toDateString(),
                'to-date' => $query->to->toDateString(),
                'page-size' => $query->pageSize,
                'page' => $query->page,
                'order-date' => 'published',
                'show-fields' => 'body'
            ]);
    }
}
