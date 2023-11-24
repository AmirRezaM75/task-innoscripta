<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Article;

class ArticleRepositoryEloquent
{
    public function save(Article $article): void
    {
        $article->save();
    }
}
