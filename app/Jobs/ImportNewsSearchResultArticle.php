<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DataTransferObjects\NewsSearchResultArticle;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use App\Repository\SourceRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

/** @method static void dispatch(NewsSearchResultArticle $newsSearchResult) */
class ImportNewsSearchResultArticle implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        private readonly NewsSearchResultArticle $article,
    ) {
        //
    }

    public function handle(
        CategoryRepository $categoryRepository,
        SourceRepository   $sourceRepository,
        ArticleRepository  $articleRepository,
        AuthorRepository   $authorRepository,
    ): void {

        $exists = $articleRepository->findByExternalId($this->article->id);

        if ($exists) {
            Log::info(sprintf('Article with external id %s exists.', $this->article->id));
            return;
        }

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

        $author = null;

        if ($this->article->author) {
            $author = $authorRepository->findBySlug($this->article->author->id);

            if ($author === null) {
                $author = new Author();
                $author->slug = $this->article->author->id;
                $author->name = $this->article->author->name;
                $authorRepository->save($author);
            }
        }

        $article = new Article();
        $article->external_id = $this->article->id;
        $article->title = $this->article->title;
        $article->description = $this->article->description;
        $article->source_id = $source->id;
        $article->category_id = $category->id;
        $article->author_id = $author?->id;
        $article->published_at = $this->article->publishedAt;

        $articleRepository->save($article);
    }
}
