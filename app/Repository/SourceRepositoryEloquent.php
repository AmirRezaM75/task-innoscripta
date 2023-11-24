<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Source;

class SourceRepositoryEloquent implements SourceRepository
{
    public function findBySlug(string $slug): Source|null
    {
        return Source::query()->where('slug', $slug)->first();
    }

    public function save(Source $source): void
    {
        $source->save();
    }
}
