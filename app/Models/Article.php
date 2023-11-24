<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $external_id
 * @property string $title
 * @property string $description
 * @property int $source_id
 * @property int $category_id
 * @property int|null $author_id
 * @property Carbon $published_at
 * @property Author|null $author
 * @property Category $category
 * @property Source $source
 */
class Article extends Model
{
    protected $casts = [
        'published_at' => 'datetime'
    ];

    /** @return BelongsTo<Author, Article> */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /** @return BelongsTo<Category, Article> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** @return BelongsTo<Source, Article> */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }
}
