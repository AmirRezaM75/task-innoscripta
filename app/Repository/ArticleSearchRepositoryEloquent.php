<?php

declare(strict_types=1);

namespace App\Repository;

use App\DataTransferObjects\ArticleSearchQuery;
use App\DataTransferObjects\ArticlesSearchResult;
use App\Models\Article;

class ArticleSearchRepositoryEloquent implements ArticleSearchRepository
{
    public function get(ArticleSearchQuery $query): ArticlesSearchResult
    {
        $base = Article::query()
            ->when($query->sourceIds, fn ($q) => $q->whereIntegerInRaw('source_id', $query->sourceIds))
            ->when($query->categoryIds, fn ($q) => $q->whereIntegerInRaw('category_id', $query->categoryIds))
            ->when($query->authorIds, fn ($q) => $q->whereIntegerInRaw('author_id', $query->authorIds))
            ->when(
                !empty($query->q),
                fn ($q) => $q->whereFullText(['title', 'description'], $query->q),
                fn ($q) => $q->orderByDesc('published_at')
            );

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
