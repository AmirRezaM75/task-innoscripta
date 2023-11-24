<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

readonly class NewsCategoryResult
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
