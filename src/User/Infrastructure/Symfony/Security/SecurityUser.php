<?php

namespace App\User\Infrastructure\Symfony\Security;

use App\User\Domain\Model\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class SecurityUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    public $id;

    public $email;

    public $password;

    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->email = $user->getEmail();
        $this->password = $user->getPassword();
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
        $this->password = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }
}
