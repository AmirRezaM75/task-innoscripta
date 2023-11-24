<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Category extends Model
{
    protected $guarded = [];
}
