<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Models\Article;
use Illuminate\Support\Enumerable;

readonly class ArticlesSearchResult
{
    /** @param Enumerable<int, Article> $articles */
    public function __construct(
        public int        $total,
        public int        $currentPage,
        public int        $pageSize,
        public Enumerable $articles,
    ) {
    }

    public function hasNextPage(): bool
    {
        $lastPage = ceil($this->total / $this->pageSize);
        return $this->currentPage < $lastPage;
    }
}
