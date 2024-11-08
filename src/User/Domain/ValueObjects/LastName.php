<?php

namespace App\User\Domain\ValueObjects;

use App\User\Domain\Exception\ValidationException;

class LastName
{
    private $lastName;

    public function __construct(string $lastName)
    {
        $this->checkFieldValidations($lastName);
        $this->lastName = $lastName;
    }

    private function checkFieldValidations(string $lastName): void
    {
        if (!preg_match('/^[a-zA-Z]+$/', $lastName)) {
            throw new ValidationException('lastName', 'can only contain alphabetic characters');

        }

        if (empty($lastName)) {
            throw new ValidationException('lastName', 'cannot be empty');

        }

        $length = mb_strlen($lastName);

        if ($length < 2 || $length > 25) {
            throw new ValidationException('lastName', 'must be between 2 and 25 characters.');
        }
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function equals(LastName $other): bool
    {
        return $this->lastName === $other->getLastName();
    }

    public function __toString(): string
    {
        return $this->lastName;
    }

}