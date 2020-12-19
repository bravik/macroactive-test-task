<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Tests\Unit\Chat\Entities;

use App\Chat\Entity\Author;
use App\Chat\Entity\Email;
use App\Chat\Entity\Id;
use App\Chat\Entity\Message;
use App\Chat\Entity\MessageStatus;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testSuccessfulCreation(): void
    {
        $id = Id::next();
        $content = 'Test content';
        $email = new Email('test@email.ru');
        $author = new Author(Id::next(), $email);
        $messageStatus = new MessageStatus('draft');

        $message = new Message($id, $content, $author, $messageStatus);

        self::assertEquals($id->getValue(), $message->getId()->getValue());
        self::assertEquals($content, $message->getContent());
        self::assertNotEmpty($message->getAuthor());
        self::assertEquals($author->getId(), $message->getAuthor()->getId());
        self::assertNotEmpty($message->getStatus());
        self::assertEquals($messageStatus->getValue(), $message->getStatus()->getValue());
    }

    public function testCreationWithEmptyContent(): void
    {
        $id = Id::next();
        $content = '';
        $email = new Email('test@email.ru');
        $author = new Author(Id::next(), $email);
        $messageStatus = new MessageStatus('draft');

        $this->expectException(InvalidArgumentException::class);

        $message = new Message($id, $content, $author, $messageStatus);
    }
}
