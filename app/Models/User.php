<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property-read int $id
 * @property string $name
 */
class User extends Authenticatable
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;
}
