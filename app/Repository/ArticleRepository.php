<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Article;

interface ArticleRepository
{
    public function findByExternalId(string $externalId): Article|null;

    public function save(Article $article): void;
}
