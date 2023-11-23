<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

readonly class NewsSearchResult
{
    public function __construct(
        public string $title,
        public string $description,
        public string $author,
        public string $source,
        public string $publishedAt,
        public string|null $category = null
    ) {
    }
}
