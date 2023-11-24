<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoryRepository
{
    public function findBySlug(string $slug): Category|null;

    public function save(Category $category): void;

    /** @return LengthAwarePaginator<Category> */
    public function get(): LengthAwarePaginator;
}
