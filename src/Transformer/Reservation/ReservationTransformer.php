<?php

declare(strict_types=1);

namespace App\Transformer\Reservation;

use App\Enum\Currency;
use App\Enum\ReservationType;
use App\Manager\ReservationManager;
use App\Model\Price;
use App\Trait\PriceCalculatorTrait;
use App\Validator\ReservationValidator;

final class ReservationTransformer extends AbstractReservationTransformer
{
    use PriceCalculatorTrait;

    public function __construct(private readonly ReservationManager $reservationManager, private readonly ReservationValidator $reservationValidator)
    {
    }

    public function transform(): void
    {
        $this->setTransformedData(
            array_map(fn (array $reservation) => $this->buildReservationResponse(
                $reservation,
            ), $this->getDataToTransform()),
        );
    }

    private function buildReservationResponse(array $reservation): array
    {
        $this->reservationValidator->validate($reservation);

        $from = min(array_keys($reservation['prices']));
        $to = max(array_keys($reservation['prices']));

        $totalPrice = Price::fromAmountAndCurrency(
            self::calculateTotalPrice($reservation['prices']),
            Currency::from($reservation['currency']),
        );
        $alreadyPaid = Price::fromAmountAndCurrency(
            (float) $reservation['alreadyPaid'],
            Currency::from($reservation['currency']),
        );

        return [
            'reservationId' => $reservation['reservationId'],
            'firstName' => explode(' ', $reservation['guest'])[0],
            'lastName' => explode(' ', $reservation['guest'])[1],
            'room' => $reservation['room'],
            'term' => $this->reservationManager->calculateTerm($from, $to, ReservationType::from($reservation['type'])),
            'priceToBePaid' => [
                ['currency' => Currency::CZK->value, 'price' => (string) self::calculatePriceToBePaid(
                    $totalPrice,
                    $alreadyPaid,
                    Currency::CZK,
                )],
                ['currency' => Currency::EUR->value, 'price' => (string) self::calculatePriceToBePaid(
                    $totalPrice,
                    $alreadyPaid,
                    Currency::EUR,
                )],
            ],
        ];
    }
}
