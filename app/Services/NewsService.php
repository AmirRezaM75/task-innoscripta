<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\NewsSearchQuery;
use App\DataTransferObjects\NewsSearchResult;
use App\Exceptions\NewsSearchException;

interface NewsService
{
    /**
     * @return NewsSearchResult[]
     * @throws NewsSearchException
     */
    public function search(NewsSearchQuery $query): array;
}
