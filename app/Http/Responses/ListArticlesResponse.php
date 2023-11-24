<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\DataTransferObjects\ArticlesSearchResult;
use App\Models\Article;
use Illuminate\Http\JsonResponse;

class ListArticlesResponse extends JsonResponse
{
    public function __construct(ArticlesSearchResult $articlesSearchResult)
    {
        parent::__construct(
            data: [
                'data' => [
                    'articles' => $articlesSearchResult->articles->map(
                        fn (Article $article) => [
                            'title' => $article->title,
                            'description' => $article->description,
                            'source' => [
                                'id' => $article->source->id,
                                'name' => $article->source->name,
                            ],
                            'category' => [
                                'id' => $article->category->id,
                                'name' => $article->category->name,
                            ],
                            'author' => $article->author === null
                                ? null
                                : [
                                    'id' => $article->author->id,
                                    'name' => $article->author->name,
                                ],
                            'publishedAt' => $article->published_at->toDateTimeString()
                        ]
                    )
                ],
                'metadata' => [
                    'total' => $articlesSearchResult->total,
                    'pageSize' => $articlesSearchResult->pageSize,
                    'currentPage' => $articlesSearchResult->currentPage,
                    'hasNextPage' => $articlesSearchResult->hasNextPage(),
                ]
            ]
        );
    }
}
