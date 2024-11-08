<?php

namespace App\User\Domain\ValueObjects;

use App\User\Domain\Exception\ValidationException;

class File
{
    private string $file;

    public function __construct(string $file)
    {
        if (!file_exists($file)) {
            throw new ValidationException('Image', 'does not exist.');
        }

        $this->file = $file;
    }

    public function value(): string
    {
        return $this->file;
    }

}