<?php

declare(strict_types=1);

namespace App\Trait;

use App\Enum\Currency;
use App\Manager\PriceManager;
use App\Model\Price;

//trait is used only once, but in expectations will be used on more places in future
trait PriceCalculatorTrait
{
    public static function calculatePriceToBePaid(Price $totalPrice, Price $alreadyPaid, Currency $currencyTo): float
    {
        $totalPrice = PriceManager::convertPriceTo($totalPrice, $currencyTo);
        $alreadyPaid = PriceManager::convertPriceTo($alreadyPaid, $currencyTo);

        return $totalPrice->amount - $alreadyPaid->amount;
    }

    public static function calculateTotalPrice(array $prices): float
    {
        return array_sum(array_values($prices));
    }
}
