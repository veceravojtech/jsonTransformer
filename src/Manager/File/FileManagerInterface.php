<?php

declare(strict_types=1);

namespace App\Manager\File;

interface FileManagerInterface
{
    public function save(string $fileName, array $content): void;

    public function load(string $fileName): array;
}
