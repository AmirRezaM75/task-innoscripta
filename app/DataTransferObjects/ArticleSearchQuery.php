<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

readonly class ArticleSearchQuery
{
    /**
     * @param int[] $sourceIds
     * @param int[] $categoryIds
     * @param int[] $authorIds
    */
    public function __construct(
        public array $sourceIds,
        public array $categoryIds,
        public array $authorIds,
        public string $q,
        public int $page,
        public int $pageSize,
    ) {
    }
}
