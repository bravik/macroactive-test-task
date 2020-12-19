<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Tests\Functional\Chat\Api;

use App\Tests\DbWebTestCase;

class MessageControllerTest extends DbWebTestCase
{
    public function testAdd(): void
    {
        $this->client->request(
            'POST',
            '/messages/add',
            [],
            [],
            ['Content-Type' => 'application/json'],
            '{"content":"Hello World", "authorEmail": "example@example.com", "isPublished": 0}'
        );
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testValidationErrors(): void
    {
        $this->client->request(
            'POST',
            '/messages/add',
            [],
            [],
            ['Content-Type' => 'application/json'],
            '{"content":"", "authorEmail": "exampleexample.com"}'
        );
        self::assertEquals(400, $this->client->getResponse()->getStatusCode());
        self::assertJson($this->client->getResponse()->getContent());

        $body = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertArrayHasKey('fields', $body);
        self::assertArrayHasKey('errors', $body);
        self::assertArrayHasKey('content', $body['fields']);
        self::assertArrayHasKey('authorEmail', $body['fields']);
    }
}
