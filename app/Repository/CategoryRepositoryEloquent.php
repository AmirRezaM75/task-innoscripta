<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function get(): LengthAwarePaginator
    {
        return Category::query()->orderBy('name')->paginate(30);
    }
}
