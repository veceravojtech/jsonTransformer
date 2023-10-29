<?php

declare(strict_types=1);

namespace Tests\Functional;

use App\Manager\File\FileManager;
use App\Transformer\Reservation\ReservationTransformer;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class FileManagerTest extends TestCase
{
    public function testLoad(): void
    {
        $fileManager = new FileManager();
        $data = $fileManager->load('reservations.json');

        self::assertIsArray($data);
    }

    public function testLoadInvalid(): void
    {
        $exception = false;
        $message = null;
        try {
            $fileManager = new FileManager();
            $fileManager->load('reservationsInvalid.json');
        } catch (RuntimeException $e) {
            $exception = true;
            $message = $e->getMessage();
        }

        self::assertTrue($exception);
        self::assertSame('Error decoding JSON data: Syntax error', $message);
    }

    public function testLoadFileFileNotFound(): void
    {
        $exception = false;
        $message = null;
        try {
            $fileManager = new FileManager();
            $fileManager->load('reservationsMissing.json');
        } catch (RuntimeException $e) {
            $exception = true;
            $message = $e->getMessage();
        }

        self::assertTrue($exception);
        self::assertSame('Failed to read JSON data from file.', $message);
    }
}
