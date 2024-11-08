<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginUserTest extends WebTestCase
{
    public function testUserLoginSuccessfully(): void
    {
        $client = static::createClient();
        $loginData = [
            'username' => 'gmaimone21@gmail.com',
            'password' => 'admin12'
        ];

        $client->request(
            'POST',
            '/api/users/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($loginData)
        );

        $this->assertResponseStatusCodeSame(200);

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $data);
    }
}