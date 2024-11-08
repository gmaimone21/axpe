<?php

namespace App\User\Domain\ValueObjects;

use App\User\Domain\Exception\ValidationException;

class FirstName
{
    private $firstName;

    public function __construct(string $firstName)
    {
        $this->checkFieldValidations($firstName);
        $this->firstName = $firstName;
    }

    private function checkFieldValidations(string $firstName): void
    {
        if (!preg_match('/^[a-zA-Z]+$/', $firstName)) {
            throw new ValidationException('firstName', 'can only contain alphabetic characters.');
        }

        if (empty($firstName)) {
            throw new ValidationException('firstName', 'can not be empty');
        }

        $length = mb_strlen($firstName);

        if ($length < 2 || $length > 25) {
            throw new ValidationException('firstName', 'does not exist.');
        }
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function equals(FirstName $other): bool
    {
        return $this->firstName === $other->getFirstName();
    }

    public function __toString(): string
    {
        return $this->firstName;
    }

}