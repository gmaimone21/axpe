<?php

namespace App\User\Application;

use App\User\Domain\Model\Image;
use App\User\Infrastructure\Doctrine\Persistence\DoctrineUserRepository;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class UserService
{
    public function __construct(private DoctrineUserRepository $userRepository)
    {
    }

    public function addImageToUser(int $userId, string $imagePath): void
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new ResourceNotFoundException('User');
        }
        $image = new Image($imagePath, $user);
        $user->addImage($image);

        $this->userRepository->save($user);
    }

}