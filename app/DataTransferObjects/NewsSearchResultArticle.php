<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Illuminate\Support\Carbon;

readonly class NewsSearchResultArticle
{
    public function __construct(
        public string                      $id,
        public string                      $title,
        public string                      $description,
        public Carbon                      $publishedAt,
        public NewsSearchResultSource      $source,
        public NewsSearchResultCategory    $category,
        public NewsSearchResultAuthor|null $author = null,
    ) {
    }
}
