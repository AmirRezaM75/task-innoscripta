<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\NewsApiSource;

interface NewsApiSourceRepository
{
    public function findByExternalId(string $externalId): NewsApiSource|null;

    public function save(NewsApiSource $model): void;
}
