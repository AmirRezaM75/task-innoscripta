<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

readonly class NewsApiSourceResult
{
    public function __construct(
        public string $id,
        public string $name,
        public string $category,
    ) {
    }
}
