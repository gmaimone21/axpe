<?php

namespace App\User\Application\Command\UserCreate;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserCreateCommand
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public bool $active,
        public string $password,
        public ?UploadedFile $avatar
    )
    {
    }

}