<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Actions\ImportNewsApiSources as ImportNewsApiSourcesAction;
use Illuminate\Console\Command;

class ImportNewsApiSources extends Command
{
    protected $signature = 'app:import-newsapi-sources';

    protected $description = 'Import NewsApi sources';

    public function handle(ImportNewsApiSourcesAction $action): int
    {
        $action->execute();

        return self::SUCCESS;
    }
}
