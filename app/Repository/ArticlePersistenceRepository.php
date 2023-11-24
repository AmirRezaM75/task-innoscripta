<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Article;

interface ArticlePersistenceRepository
{
    public function save(Article $article): void;
}
