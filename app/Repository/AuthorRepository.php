<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AuthorRepository
{
    public function findBySlug(string $slug): Author|null;

    public function save(Author $author): void;

    /** @return LengthAwarePaginator<Author> */
    public function get(): LengthAwarePaginator;
}
