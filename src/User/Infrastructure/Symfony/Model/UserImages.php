<?php

namespace App\User\Infrastructure\Symfony\Model;

use App\User\Domain\Model\Image;
use App\User\Domain\Model\User;


class UserImages implements \JsonSerializable
{
    private $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function jsonSerialize(): array
    {
        return [
            'url' => $this->image->getUrl(),
            'name' => $this->image->getName(),
        ];
    }
}
