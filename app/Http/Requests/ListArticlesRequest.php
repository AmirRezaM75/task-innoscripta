<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class ListArticlesRequest extends Data
{
    public function __construct(
        #[Sometimes]
        #[IntegerType]
        #[Min(1)]
        public readonly ?int $sourceId,
        #[Sometimes]
        #[IntegerType]
        #[Min(1)]
        public readonly ?int $categoryId,
        #[Sometimes]
        #[IntegerType]
        #[Min(1)]
        public readonly ?int $authorId,
        #[Sometimes]
        #[StringType]
        public readonly string $q = '',
        #[Sometimes]
        #[IntegerType]
        #[Min(1)]
        public readonly int $page = 1,
        #[Sometimes]
        #[IntegerType]
        #[Min(1)]
        public readonly int $pageSize = 10,
    ) {
    }
}
