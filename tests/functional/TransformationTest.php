<?php

declare(strict_types=1);

namespace Tests\Functional;

use App\Manager\File\FileManager;
use App\Manager\ReservationManager;
use App\Transformer\Reservation\ReservationTransformer;
use App\Validator\ReservationValidator;
use Iterator;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class TransformationTest extends TestCase
{
    public function testTransformationFromFile(): void
    {
        $fileManager = new FileManager();
        $reservationTransformer = self::buildReservationTransformer();
        $data = $fileManager->load('reservations.json');
        $reservationTransformer->setDataToTransform($data);
        $reservationTransformer->transform();
        $fileManager->save('reservations_transformed.json', $reservationTransformer->getTransformedData());

        self::assertSame(
            json_decode(file_get_contents(__DIR__ . '/../common/reservations_correct.json'), true),
            json_decode(file_get_contents(__DIR__ . '/../../tmp/reservations_transformed.json'), true)
        );
    }

    /**
     * @dataProvider transformationFromInvalidDataProvider
     */
    public function testTransformationFromInvalidData(array $data, string $expectedMessage): void
    {
        $exception = false;
        $message = null;
        try {
            $reservationTransformer = self::buildReservationTransformer();
            $reservationTransformer->setDataToTransform($data);
            $reservationTransformer->transform();
        } catch (RuntimeException $e) {
            $exception = true;
            $message = $e->getMessage();
        }

        self::assertTrue($exception);
        self::assertSame($expectedMessage, $message);
    }

    public static function transformationFromInvalidDataProvider(): iterator
    {
        yield 'invalid array' =>
        [
            'data' => [
                0 => [
                'reservationId' => 123456,
                'guest' => ''
                ],
            ],
            'expectedMessage' => 'Failed to validate reservation.',
        ];
    }

    private static function buildReservationTransformer(): ReservationTransformer
    {
        return new ReservationTransformer(new ReservationManager(), new ReservationValidator());
    }
}
