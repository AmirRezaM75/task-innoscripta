<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Source;

interface SourceRepository
{
    public function findBySlug(string $slug): Source|null;

    public function save(Source $source): void;
}
