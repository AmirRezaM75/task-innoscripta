<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Article;

class ArticleRepositoryEloquent implements ArticleRepository
{
    public function findByExternalId(string $externalId): Article|null
    {
        return Article::query()->where('external_id', $externalId)->first();
    }

    public function save(Article $article): void
    {
        $article->save();
    }
}
