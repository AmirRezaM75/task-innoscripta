<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Article;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/** @method static void dispatch(Article $article) */
class ArticleCreated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public readonly Article $article)
    {

    }
}
