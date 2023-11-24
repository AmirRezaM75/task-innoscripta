<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Illuminate\Support\Carbon;

readonly class NewsArticleResult
{
    public function __construct(
        public string             $id,
        public string             $title,
        public string             $description,
        public Carbon             $publishedAt,
        public NewsSourceResult   $source,
        public NewsCategoryResult $category,
        public string|null        $author = null,
    ) {
    }
}
