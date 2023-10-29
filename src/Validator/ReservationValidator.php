<?php

declare(strict_types=1);

namespace App\Validator;

use RuntimeException;

final readonly class ReservationValidator
{
    public function validate(array $reservation): void
    {
        if (
            !isset(
                $reservation['reservationId'],
                $reservation['guest'],
                $reservation['room'],
                $reservation['type'],
                $reservation['prices'],
                $reservation['alreadyPaid']
            ) ||
            !is_array($reservation['prices']) ||
            empty($reservation['prices']) ||
            !is_numeric($reservation['reservationId']) ||
            !is_numeric($reservation['alreadyPaid'])
        ) {
            throw new RuntimeException('Failed to validate reservation.');
        }
    }
}
