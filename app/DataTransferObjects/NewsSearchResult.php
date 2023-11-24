<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

readonly class NewsSearchResult
{
    /** @param NewsArticleResult[] $articles */
    public function __construct(
        public bool $hasNextPage,
        public array $articles
    ) {
    }
}
