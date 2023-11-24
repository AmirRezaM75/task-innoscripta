<?php

declare(strict_types=1);

namespace App\Repository;

use App\DataTransferObjects\ArticlesSearchResult;
use App\Http\Requests\ListArticlesRequest;
use App\Models\Article;

class ArticleSearchRepositoryEloquent implements ArticleSearchRepository
{
    public function get(ListArticlesRequest $query): ArticlesSearchResult
    {
        $base = Article::query()
            ->when($query->sourceId, fn ($q) => $q->where('source_id', $query->sourceId))
            ->when($query->categoryId, fn ($q) => $q->where('category_id', $query->categoryId))
            ->when($query->authorId, fn ($q) => $q->where('author_id', $query->authorId))
            ->when(!empty($query->q), fn ($q) => $q->whereFullText('description', $query->q));

        $total = $base->count();

        $offset = ($query->page - 1) * $query->pageSize;

        $articles = $base
            ->with(['category', 'author', 'source'])
            ->offset($offset)
            ->limit($query->pageSize)
            ->get();

        return new ArticlesSearchResult(
            $total,
            $query->page,
            $query->pageSize,
            $articles,
        );
    }
}
