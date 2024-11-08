<?php

namespace App\User\Domain\ValueObjects;

use App\User\Domain\Exception\ValidationException;

class IsActive
{
    private $isActive;

    public function __construct(bool|string $isActive)
    {
        $this->checkFieldValidations($isActive);
        $this->isActive = $isActive;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function equals(IsActive $other): bool
    {
        return $this->isActive === $other->isActive();
    }

    public function __toString(): string
    {
        return $this->isActive ? 'true' : 'false';
    }

    public function __toNumber(): int
    {
        return $this->isActive ? 1 : 0;
    }

    private function checkFieldValidations($isActive): void
    {
        if (!is_bool($isActive) && (((int)$isActive !== 0)  && (int)$isActive !== 1)) {
            throw new ValidationException('isActive', 'Only accept true or false as value');
        }
    }
}