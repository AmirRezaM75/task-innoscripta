<?php

declare(strict_types=1);

namespace App\Repository;

use App\DataTransferObjects\ArticleSearchQuery;
use App\DataTransferObjects\ArticlesSearchResult;

interface ArticleSearchRepository
{
    public function get(ArticleSearchQuery $query): ArticlesSearchResult;
}
