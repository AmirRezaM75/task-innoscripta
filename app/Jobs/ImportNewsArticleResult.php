<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DataTransferObjects\NewsArticleResult;
use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\SourceRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

/** @method static void dispatch(NewsArticleResult $newsSearchResult) */
class ImportNewsArticleResult implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        private readonly NewsArticleResult $article,
    )
    {
        //
    }

    public function handle(
        CategoryRepository $categoryRepository,
        SourceRepository   $sourceRepository,
        ArticleRepository  $articleRepository,
    ): void
    {
        $category = $categoryRepository->findBySlug($this->article->category->id);

        if ($category === null) {
            $category = new Category();
            $category->slug = $this->article->category->id;
            $category->name = $this->article->category->name;
            $categoryRepository->save($category);
        }

        $source = $sourceRepository->findBySlug($this->article->source->id);

        if ($source === null) {
            $source = new Source();
            $source->slug = $this->article->source->id;
            $source->name = $this->article->source->name;
            $sourceRepository->save($source);
        }

        $article = new Article();
        $article->title = $this->article->title;
        $article->description = $this->article->description;
        $article->source_id = $source->id;
        $article->category_id = $category->id;
        $article->published_at = $this->article->publishedAt;

        $articleRepository->save($article);
    }
}
