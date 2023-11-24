<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Category;
use App\Repository\CategoryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListCategories
{
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    /** @return LengthAwarePaginator<Category> */
    public function execute(): LengthAwarePaginator
    {
        return $this->categoryRepository->get();
    }
}
