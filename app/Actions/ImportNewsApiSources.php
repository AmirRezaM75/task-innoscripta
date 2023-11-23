<?php

declare(strict_types=1);

namespace App\Actions;

use App\Exceptions\NewsApiSourcesException;
use App\Models\NewsApiSource;
use App\Repository\NewsApiSourceRepository;
use App\Services\NewsApiService;

class ImportNewsApiSources
{
    public function __construct(
        private readonly NewsApiService $newsApiService,
        private readonly NewsApiSourceRepository $newsApiSourceRepository
    ) {
    }

    /**
     * @throws NewsApiSourcesException
    */
    public function execute(): void
    {
        $sources = $this->newsApiService->sources();

        foreach ($sources as $source) {
            $exists = $this->newsApiSourceRepository->findByExternalId($source->id);

            if ($exists) {
                continue;
            }

            $newsApiSource = new NewsApiSource();
            $newsApiSource->external_id = $source->id;
            $newsApiSource->name = $source->name;
            $newsApiSource->category = $source->category;

            $this->newsApiSourceRepository->save($newsApiSource);
        }
    }
}
