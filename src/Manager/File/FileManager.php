<?php

declare(strict_types=1);

namespace App\Manager\File;

use RuntimeException;

final readonly class FileManager implements FileManagerInterface
{
    private const PUBLIC_PATH = '/../../../public';
    private const TEMP_PATCH = '/../../../tmp';

    public function save(string $fileName, array $content): void
    {
        $dir = __DIR__ . self::TEMP_PATCH;

        if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
            throw new RuntimeException('Failed to create directory.');
        }

        if (false === file_put_contents(
            $dir . sprintf('/%s', $fileName),
            json_encode($content, JSON_PRETTY_PRINT),
        )) {
            throw new RuntimeException('Failed to save transformed data to file.');
        }
    }

    public function load(string $fileName): array
    {
        $jsonData = file_get_contents(__DIR__ . self::PUBLIC_PATH . sprintf('/%s', $fileName));

        if (false === $jsonData) {
            throw new RuntimeException('Failed to read JSON data from file.');
        }

        $data = json_decode($jsonData, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException('Error decoding JSON data: ' . json_last_error_msg());
        }

        return $data;
    }
}
