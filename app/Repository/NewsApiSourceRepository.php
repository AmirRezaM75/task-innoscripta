<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\NewsApiSource;
use Illuminate\Support\Collection;

interface NewsApiSourceRepository
{
    /** @return Collection<int, NewsApiSource> */
    public function get(int $limit, int $offset): Collection;

    public function findByExternalId(string $externalId): NewsApiSource|null;

    public function save(NewsApiSource $model): void;
}
