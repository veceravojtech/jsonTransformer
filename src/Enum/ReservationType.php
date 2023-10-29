<?php

declare(strict_types=1);

namespace App\Enum;

enum ReservationType: string
{
    case DAY = 'day';
    case HOUR = 'hour';
}
