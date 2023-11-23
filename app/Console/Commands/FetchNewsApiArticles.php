<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Actions\GetNews;
use App\Constants\NewsDataSource;
use App\DataTransferObjects\NewsSearchQuery;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class FetchNewsApiArticles extends Command
{
    /** @var string */
    protected $signature = 'app:fetch-news-api-articles {--from=} {--to=}';

    /** @var string */
    protected $description = 'Fetch articles from NewsApi and store in database.';

    public function handle(GetNews $action): int
    {
        $from = $this->option('from') ? Carbon::parse($this->option('from')) : now()->startOfDay();
        $to = $this->option('to') ? Carbon::parse($this->option('to')) : now()->endOfDay();

        $page = 1;

        do {
            $query = new NewsSearchQuery(
                from: $from,
                to: $to,
                page: $page,
            );

            $articles = $action->execute(NewsDataSource::NewsApi, $query);
        } while (count($articles) === $query->pageSize);

        return self::SUCCESS;
    }
}
