<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property string $external_id
 * @property string $title
 * @property string $description
 * @property int $source_id
 * @property int $category_id
 * @property int|null $author_id
 * @property Carbon $published_at
*/
class Article extends Model
{
    protected $casts = [
        'published_at' => 'datetime'
    ];
}
