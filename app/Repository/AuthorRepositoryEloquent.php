<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuthorRepositoryEloquent implements AuthorRepository
{
    public function findBySlug(string $slug): Author|null
    {
        return Author::query()->where('slug', $slug)->first();
    }

    public function save(Author $author): void
    {
        $author->save();
    }

    public function get(): LengthAwarePaginator
    {
        return Author::query()->orderBy('name')->paginate();
    }
}
