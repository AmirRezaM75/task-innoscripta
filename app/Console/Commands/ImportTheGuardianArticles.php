<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Actions\ImportTheGuardianArticles as ImportTheGuardianArticlesAction;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ImportTheGuardianArticles extends Command
{
    /** @var string */
    protected $signature = 'app:import-guardian-articles {--from=} {--to=}';

    /** @var string */
    protected $description = 'Fetch articles from The Guardian and store them in database.';

    public function handle(ImportTheGuardianArticlesAction $action): int
    {
        $from = $this->option('from') ? Carbon::parse($this->option('from')) : now()->startOfDay();

        $to = $this->option('to') ? Carbon::parse($this->option('to')) : now()->endOfDay();

        $action->execute($from, $to);

        return self::SUCCESS;
    }
}
