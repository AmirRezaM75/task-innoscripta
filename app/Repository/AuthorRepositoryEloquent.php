<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Author;

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
}
