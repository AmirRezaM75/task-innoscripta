<?php

declare(strict_types=1);

namespace App\Actions;

use App\DataTransferObjects\ArticlesSearchResult;
use App\Http\Requests\ListArticlesRequest;
use App\Repository\ArticleSearchRepository;

class ListArticles
{
    public function __construct(private readonly ArticleSearchRepository $articleSearchRepository)
    {
    }

    public function execute(ListArticlesRequest $request): ArticlesSearchResult
    {
        return $this->articleSearchRepository->get($request);
    }
}
