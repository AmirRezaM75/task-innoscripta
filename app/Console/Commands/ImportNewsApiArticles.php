<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Actions\ImportNewsApiArticles as ImportNewsApiArticlesAction;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ImportNewsApiArticles extends Command
{
    /** @var string */
    protected $signature = 'app:import-newsapi-articles {--from=} {--to=}';

    /** @var string */
    protected $description = 'Fetch articles from NewsApi and store them in database.';

    public function handle(ImportNewsApiArticlesAction $action): int
    {
        $from = $this->option('from') ? Carbon::parse($this->option('from')) : now()->startOfDay();

        $to = $this->option('to') ? Carbon::parse($this->option('to')) : now()->endOfDay();

        $action->execute($from, $to);

        return self::SUCCESS;
    }
}
