<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mappings\ArticleMapping;
use App\Mappings\Mapping;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class ProcessMappings extends Command
{
    protected $signature = 'app:process-mappings {--force}';

    protected $description = 'Process elasticsearch mappings and apply them if does not exist.';

    /** @var class-string<Mapping>[] */
    private array $mappings = [
        ArticleMapping::class,
    ];

    public function handle(): void
    {
        foreach ($this->mappings as $mapping) {
            /** @var Mapping $mapper */
            $mapper = App::make($mapping);

            try {
                $this->info("Creating mapping for {$mapper->getIndexName()}");

                if ($mapper->exists()) {
                    $this->warn("Mapping already exists for {$mapper->getIndexName()}");

                    if ($this->option('force')) {
                        $mapper->drop();
                        $this->info("Dropped mapping for {$mapper->getIndexName()}");
                    } else {
                        continue;
                    }
                }

                $mapper->create();
                $this->info("Created mapping for {$mapper->getIndexName()}");
            } catch (Exception $exception) {
                $this->error($exception->getMessage());
            }
        }
    }
}
