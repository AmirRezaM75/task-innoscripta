<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Carbon;

readonly class NewsSearchQuery
{
    public function __construct(
        public Carbon $from,
        public Carbon $to,
        public int $page = 1,
        public int $pageSize = 100,
        public string $sortBy = 'publishedAt'
    )
    {
    }
}
