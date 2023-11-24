<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Source;
use App\Repository\SourceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListSources
{
    public function __construct(private readonly SourceRepository $sourceRepository)
    {
    }

    /** @return LengthAwarePaginator<Source> */
    public function execute(): LengthAwarePaginator
    {
        return $this->sourceRepository->get();
    }
}
