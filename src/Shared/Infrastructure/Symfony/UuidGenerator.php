<?php

namespace App\Shared\Infrastructure\Symfony;

use App\Shared\Application\Service\UuidGeneratorInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

class UuidGenerator implements UuidGeneratorInterface
{
    private $uuidFactory;

    public function __construct(UuidFactory $uuidFactory)
    {
        $this->uuidFactory = $uuidFactory;
    }

    public function generate()
    {
        return $this->uuidFactory->create();
    }
}
