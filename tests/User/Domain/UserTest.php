<?php

namespace App\Tests\User\Domain;

use App\User\Domain\Exception\ValidationException;
use App\User\Domain\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserCreationWithValidEmail(): void
    {
        $user = new User('ddd-asadd-w212313', 'John', 'Doe', 'johndoe@example.com', 'admin12', false, 'www.url.com');

        $this->assertEquals('johndoe@example.com', $user->getEmail());
        $this->assertEquals('www.url.com', $user->getAvatar());
        $this->assertEquals('John', $user->getFirstName());
    }
}