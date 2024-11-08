<?php

namespace App\User\Application\Command\UploadImage;

class UploadImageCommand
{
    public function __construct(
        public array $uploadedFile,
        public string $userId,
        public array $name
    )
    {
    }
}