<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property int $target_type
 * @property int $target_id
*/
class UserPreference extends Model
{
    protected $guarded = [];
}
