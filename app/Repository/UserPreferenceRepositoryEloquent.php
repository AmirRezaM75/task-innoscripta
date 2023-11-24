<?php

declare(strict_types=1);

namespace App\Repository;

use App\Constants\TargetType;
use App\Models\UserPreference;
use Illuminate\Support\Enumerable;

class UserPreferenceRepositoryEloquent implements UserPreferenceRepository
{
    public function get(int $userId, TargetType $targetType, int $limit = 5): Enumerable
    {
        return UserPreference::query()
            ->where('user_id', $userId)
            ->where('target_type', $targetType->value)
            ->limit($limit)
            ->get();
    }
}
