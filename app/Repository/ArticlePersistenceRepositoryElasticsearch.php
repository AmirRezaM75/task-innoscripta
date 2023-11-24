<?php

declare(strict_types=1);

namespace App\Repository;

use App\Mappings\ArticleMapping;
use App\Models\Article;
use Elastic\Elasticsearch\Client;

class ArticlePersistenceRepositoryElasticsearch implements ArticlePersistenceRepository
{
    public function __construct(private readonly Client $client)
    {
    }

    public function save(Article $article): void
    {
        $params = [
            'index' => ArticleMapping::getIndexName(),
            'id' => $article->id,
            'body' => [
                'id' => $article->id,
                'title' => $article->title,
                'description' => $article->description,
                'publishedAt' => $article->published_at->toDateTimeString(),
                'author' => $article->author ? [
                    'id' => $article->author->id,
                    'name' => $article->author->name,
                    'slug' => $article->author->slug,
                ] : null,
                'category' => [
                    'id' => $article->category->id,
                    'name' => $article->category->name,
                    'slug' => $article->category->slug,
                ],
                'source' => [
                    'id' => $article->source->id,
                    'name' => $article->source->name,
                    'slug' => $article->source->slug,
                ],
            ]
        ];

        $this->client->index($params);
    }
}
