<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Constants\NewsDataSource;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

class NewsSearchQuery
{
    /** @var string[] */
    private array $sources;

    public function __construct(
        public readonly NewsDataSource $dataSource,
        public readonly Carbon $from,
        public readonly Carbon $to,
        public readonly int $page = 1,
        public readonly int $pageSize = 100,
    ) {
    }

    /** @param string[] $sources */
    public function setSources(array $sources): void
    {
        if ($this->dataSource !== NewsDataSource::NewsApi) {
            throw new InvalidArgumentException("Sources filter is not supported for {$this->dataSource->value} data source.");
        }

        $this->sources = $sources;
    }

    public function getSources(): string
    {
        return implode(',', $this->sources);
    }
}
