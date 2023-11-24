<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\NewsSearchQuery;
use App\DataTransferObjects\NewsSearchResult;
use App\Exceptions\MaximumResultsReachedException;
use App\Exceptions\NewsApiSourceNotFoundException;
use App\Exceptions\NewsSearchException;

interface NewsService
{
    /**
     * @throws NewsSearchException
     * @throws NewsApiSourceNotFoundException
     * @throws MaximumResultsReachedException
     */
    public function search(NewsSearchQuery $query): NewsSearchResult;
}
