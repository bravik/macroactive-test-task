<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Tests\Functional\Chat\Api;

use App\Tests\DbWebTestCase;

class ChatControllerTest extends DbWebTestCase
{
    public function testIndex(): void
    {
        $this->client->request('GET', '/');

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertJson($this->client->getResponse()->getContent());

        $body = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertArrayHasKey('messages', $body);
    }

    public function testLeaderboard(): void
    {
        $this->client->request('GET', '/leaderboard');

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertJson($this->client->getResponse()->getContent());

        $body = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertArrayHasKey('topAuthors', $body);
        self::assertArrayHasKey('topWriters', $body);
    }
}
