<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $external_id
 * @property string $name
 * @property string $category
*/
class NewsApiSource extends Model
{
    public $timestamps = false;

    protected $guarded = [];
}
