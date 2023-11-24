<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Category;

class CategoryRepositoryEloquent implements CategoryRepository
{
    public function findBySlug(string $slug): Category|null
    {
        return Category::query()->where('slug', $slug)->first();
    }

    public function save(Category $category): void
    {
        $category->save();
    }
}
