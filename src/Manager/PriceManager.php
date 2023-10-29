<?php

declare(strict_types=1);

namespace App\Manager;

use App\Enum\Currency;
use App\Model\Price;
use InvalidArgumentException;

final readonly class PriceManager
{
    public const EUR_RATIO = 26;

    public static function convertPriceTo(Price $price, Currency $currency): Price
    {
        $closure = (match ($price->currency) {
            Currency::EUR => function ($price, $currency) {
                if (Currency::EUR === $currency) {
                    return $price->amount;
                }

                if (Currency::CZK === $currency) {
                    return $price->amount * self::EUR_RATIO;
                }

                self::incorrectCurrency($currency);
            },
            Currency::CZK => function ($price, $currency) {
                if (Currency::EUR === $currency) {
                    return $price->amount / self::EUR_RATIO;
                }

                if (Currency::CZK === $currency) {
                    return $price->amount;
                }

                self::incorrectCurrency($currency);
            }
        });

        $convertedAmount = $closure($price, $currency);

        return Price::fromAmountAndCurrency($convertedAmount, $currency);
    }

    private static function incorrectCurrency(Currency $currency): void
    {
        throw new InvalidArgumentException(sprintf('Unsupported currency: %s', $currency->value));
    }
}
