<?php

namespace App\User\Domain\Exception;

use InvalidArgumentException;

class ValidationException extends InvalidArgumentException
{
    public function __construct(string $field, string $message)
    {
        parent::__construct(sprintf('Validation failed for %s: %s', $field, $message));
    }
}