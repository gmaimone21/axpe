<?php

namespace App\User\Infrastructure\Symfony\Security;

use App\User\Domain\Contracts\PasswordHasherInterface;
use App\User\Domain\Model\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordHasher implements PasswordHasherInterface
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function hashPassword(User $user): void
    {
        $symfonyUser = new SecurityUser($user);
        $user->setPassword($this->hasher->hashPassword($symfonyUser, $user->getPlainPassword()));
    }
}
