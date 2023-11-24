<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

readonly class NewsSearchResultCategory
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
