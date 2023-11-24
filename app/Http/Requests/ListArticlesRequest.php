<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
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
        #[Sometimes]
        #[BooleanType]
        public readonly bool $preferential = false,
    ) {
    }

    public function getAuthId(): int|null
    {
        // This must come from authenticate middleware
        // but, it's outside the scope of this project
        // Also, repository pattern is ignored.
        /** @var User|null $user */
        $user = User::query()->first();
        return $user?->id;
    }
}
