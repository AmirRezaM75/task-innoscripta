<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Actions\ImportTheNewYorkTimesArticles as ImportTheNewYorkTimesArticlesAction;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ImportTheNewYorkTimesArticles extends Command
{
    /** @var string */
    protected $signature = 'app:import-nytimes-articles {--from=} {--to=}';

    /** @var string */
    protected $description = 'Fetch articles from The New York Times and store them in database.';

    public function handle(ImportTheNewYorkTimesArticlesAction $action): int
    {
        $from = $this->option('from') ? Carbon::parse($this->option('from')) : now()->startOfDay();

        $to = $this->option('to') ? Carbon::parse($this->option('to')) : now()->endOfDay();

        $action->execute($from, $to);

        return self::SUCCESS;
    }
}
