<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserControllerTest extends WebTestCase
{
    public function testSuccessfulUserRegistration(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/users/register',
            [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => 'johnddddoe@example111111'.rand().'.com',
                'isActive' => 1,
                'password' => 'admin12'
            ],
            [],
            ['CONTENT_TYPE' => 'multipart/form-data']
        );

        $this->assertResponseStatusCodeSame(201);
    }

    public function testUserRegistrationWithInvalidEmail(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/users/register',
            [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => 'wrong email',
                'isActive' => 1,
                'password' => 'admin12'
            ],
            [],
            ['CONTENT_TYPE' => 'multipart/form-data']
        );

        $this->assertResponseStatusCodeSame(400);
    }
}