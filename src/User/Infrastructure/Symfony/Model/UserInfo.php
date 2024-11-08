<?php

namespace App\User\Infrastructure\Symfony\Model;

use App\User\Domain\Model\Image;
use App\User\Domain\Model\User;


class UserInfo implements \JsonSerializable
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->user->getId(),
            'firstName' => $this->user->getFirstName(),
            'lastName' => $this->user->getLastName(),
            'fullName' => $this->user->getFullName(),
            'email' => $this->user->getEmail(),
            'active' => $this->user->isActive(),
            'avatar' => $this->user->getAvatar(),
            'images' => array_map(static fn (Image $image) => new UserImages($image), $this->user->getImages()->toArray()),
        ];
    }
}