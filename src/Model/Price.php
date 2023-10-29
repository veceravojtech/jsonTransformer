<?php

declare(strict_types=1);

namespace App\Model;

use App\Enum\Currency;

final class Price
{
    public const PRECISION = 2;
    private function __construct(public float $amount, public readonly Currency $currency)
    {
        $this->amount = round($amount, self::PRECISION);
    }

    public static function fromAmountAndCurrency(float $amount, Currency $currency): self
    {
        return new self(...func_get_args());
    }
}
