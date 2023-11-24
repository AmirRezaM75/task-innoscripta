<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\NewsApiSource;
use Illuminate\Support\Collection;

class NewsApiSourceRepositoryEloquent implements NewsApiSourceRepository
{
    public function get(int $limit, int $offset): Collection
    {
        return NewsApiSource::query()
            ->latest('id')
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    public function findByExternalId(string $externalId): NewsApiSource|null
    {
        return NewsApiSource::query()->where('external_id', $externalId)->first();
    }

    public function save(NewsApiSource $model): void
    {
        $model->save();
    }
}
