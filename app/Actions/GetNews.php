<?php

namespace App\Actions;

use App\Constants\NewsDataSource;
use App\DataTransferObjects\NewsSearchQuery;
use App\DataTransferObjects\NewsSearchResult;
use App\Exceptions\NewsSearchException;
use App\Services\NewsServiceFactory;

class GetNews
{
    /**
     * @return NewsSearchResult[]
     * @throws NewsSearchException
     */
    public function execute(NewsDataSource $source, NewsSearchQuery $query): array
    {
        $service = NewsServiceFactory::build($source);
        return $service->search($query);
    }
}
