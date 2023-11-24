<?php

declare(strict_types=1);

namespace App\Repository;

use App\DataTransferObjects\ArticlesSearchResult;
use App\Http\Requests\ListArticlesRequest;

interface ArticleSearchRepository
{
    public function get(ListArticlesRequest $query): ArticlesSearchResult;
}
