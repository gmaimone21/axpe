<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserInfoControllerTest extends WebTestCase
{
    private function authenticate($client): string
    {
        $client->request(
            'POST',
            '/api/users/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => 'gmaimone21@gmail.com',
                'password' => 'admin12'
            ])
        );

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        return $data['token'];
    }

    public function testGetUserDetailsSuccessfully(): void
    {
        $client = static::createClient();

        $token = $this->authenticate($client);

        $client->request(
            'GET',
            "/api/users/me",
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token)
            ]
        );

        $this->assertResponseStatusCodeSame(200);

        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $content = $client->getResponse()->getContent();
        $data = json_decode($content, true);

        $this->assertArrayHasKey('email', $data);
        $this->assertArrayHasKey('firstName', $data);
        $this->assertArrayHasKey('lastName', $data);

        $this->assertEquals('gmaimone21@gmail.com', $data['email']);
        $this->assertEquals('Gustavo Maimone', $data['fullName']);
    }
}