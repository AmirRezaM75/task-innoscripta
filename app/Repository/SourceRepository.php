<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Source;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SourceRepository
{
    public function findBySlug(string $slug): Source|null;

    public function save(Source $source): void;

    /** @return LengthAwarePaginator<Source> */
    public function get(): LengthAwarePaginator;
}
