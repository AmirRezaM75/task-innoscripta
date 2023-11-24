<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Author;
use App\Repository\AuthorRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListAuthors
{
    public function __construct(private readonly AuthorRepository $authorRepository)
    {
    }

    /** @return LengthAwarePaginator<Author> */
    public function execute(): LengthAwarePaginator
    {
        return $this->authorRepository->get();
    }
}
