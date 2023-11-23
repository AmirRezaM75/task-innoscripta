<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\NewsApiSource;

class NewsApiSourceRepositoryEloquent implements NewsApiSourceRepository
{
    public function findByExternalId(string $externalId): NewsApiSource|null
    {
        return NewsApiSource::query()->where('external_id', $externalId)->first();
    }

    public function save(NewsApiSource $model): void
    {
        $model->save();
    }
}
