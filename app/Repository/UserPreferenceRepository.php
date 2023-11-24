<?php

declare(strict_types=1);

namespace App\Repository;

use App\Constants\TargetType;
use App\Models\UserPreference;
use Illuminate\Support\Enumerable;

interface UserPreferenceRepository
{
    /** @return Enumerable<int, UserPreference> */
    public function get(int $userId, TargetType $targetType, int $limit = 10): Enumerable;
}
