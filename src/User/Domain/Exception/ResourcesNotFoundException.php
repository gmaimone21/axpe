<?php

namespace App\User\Domain\Exception;

use Exception;

class ResourcesNotFoundException extends Exception
{
    public function __construct(string $resource)
    {
        $message = sprintf(
            'Resource %s not exist',
            $resource
        );
        parent::__construct($message);
    }
}
