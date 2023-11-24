<?php

declare(strict_types=1);

namespace App\Constants;

enum NewsDataSource: string
{
    case NewsApi = 'news-api';
    case TheGuardian = 'the-guardian';
}
