<?php

namespace App\User\Domain\ValueObjects;

use App\User\Domain\Exception\ValidationException;

class Email
{
    private $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException('email', 'Invalid email format');
        }

        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function equals(Email $other): bool
    {
        return $this->email === $other->getEmail();
    }

    public function __toString(): string
    {
        return $this->email;
    }

}