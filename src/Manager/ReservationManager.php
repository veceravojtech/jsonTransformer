<?php

declare(strict_types=1);

namespace App\Manager;

use App\Enum\ReservationType;
use DateInterval;
use DateTime;

final readonly class ReservationManager
{
    public function calculateTerm(string $from, string $to, ReservationType $type): array
    {
        return match ($type) {
            ReservationType::DAY => self::handleDays($from, $to),
            ReservationType::HOUR => self::handleHours($from, $to),
        };
    }

    private static function handleDays(string $from, string $to): array
    {
        $startDate = new DateTime($from);
        $endDate = (new DateTime($to))->add(DateInterval::createFromDateString('1 day'));
        $interval = $startDate->diff($endDate);

        return [
            'from' => $from,
            'to' => $endDate->format('Y-m-d'),
            'nights' => $interval->days,
        ];
    }

    private static function handleHours(string $from, string $to): array
    {
        $startDate = new DateTime($from);
        $endDate = new DateTime($to);
        $interval = $startDate->diff($endDate);

        return [
            'from' => $from,
            'to' => $to,
            'hours' => $interval->h + 1,
        ];
    }
}
