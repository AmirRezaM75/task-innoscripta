<?php

declare(strict_types=1);

namespace App\Constants;

enum PreferenceTargetType: string
{
    case Author = 'author';
    case Category = 'category';
    case Source = 'source';
}
