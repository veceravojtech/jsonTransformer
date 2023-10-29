<?php

declare(strict_types=1);

namespace Tests\Functional;

use App\Enum\Currency;
use App\Manager\PriceManager;
use App\Model\Price;
use PHPUnit\Framework\TestCase;

final class CurrencyTest extends TestCase
{
    /**
     * @dataProvider currencyProvider
     */
    public function testCurrency(float $amount, Currency $currencyFrom, Currency $currencyTo, float $expectedAmount): void
    {
        $price = Price::fromAmountAndCurrency($amount, $currencyFrom);
        $convertedPrice = (new PriceManager())->convertPriceTo($price, $currencyTo);

        self::assertSame($expectedAmount, $convertedPrice->amount);
        self::assertSame($currencyTo, $convertedPrice->currency);
    }

    public static function currencyProvider(): iterable
    {
        yield 'czk to eur' => [
            'amount' => 20,
            'currencyFrom' => Currency::CZK,
            'currencyTo' => Currency::EUR,
            'expectedAmount' => round(20 / PriceManager::EUR_RATIO, Price::PRECISION),
        ];
        yield 'eur to eur' => [
            'amount' => 20,
            'currencyFrom' => Currency::EUR,
            'currencyTo' => Currency::EUR,
            'expectedAmount' => 20,
        ];
        yield 'czk to czk' => [
            'amount' => 20,
            'currencyFrom' => Currency::CZK,
            'currencyTo' => Currency::CZK,
            'expectedAmount' => 20,
        ];
        yield 'eur to czk' => [
            'amount' => 20,
            'currencyFrom' => Currency::EUR,
            'currencyTo' => Currency::CZK,
            'expectedAmount' => round(20 * PriceManager::EUR_RATIO, Price::PRECISION),
        ];
    }
}
