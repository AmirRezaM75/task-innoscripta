<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ArticleCreated;
use App\Repository\ArticlePersistenceRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImportArticleIntoElastic implements ShouldQueue
{
    public int $tries = 5;

    public int $backoff = 10;

    public function __construct(
        private readonly ArticlePersistenceRepository $articlePersistenceRepository
    ) {
    }

    public function handle(ArticleCreated $event): void
    {
        $this->articlePersistenceRepository->save($event->article);
    }
}
