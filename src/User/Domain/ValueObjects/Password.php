<?php

namespace App\User\Domain\ValueObjects;

use App\User\Domain\Exception\ValidationException;

class Password
{
    private $password;

    public function __construct(string $password)
    {
        $this->checkFieldValidations($password);
        $this->password = $password;
    }

    private function checkFieldValidations(string $password): void
    {
        if (!preg_match('/^(?=.*\d)[a-zA-Z\d]+$/', $password)) {
            throw new ValidationException('password', 'must be between 2 and 25 characters.');
        }

        if (empty($password)) {
            throw new ValidationException('password', 'cannot be empty.');
        }

        $length = mb_strlen($password);

        if ($length < 6 || $length > 50) {
            throw new ValidationException('password', 'must be between 6 and 50 characters.');
        }
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function equals(Password $other): bool
    {
        return $this->password === $other->getPassword();
    }

    public function __toString(): string
    {
        return $this->password;
    }

}