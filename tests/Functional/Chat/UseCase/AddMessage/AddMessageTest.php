<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Tests\Functional\Chat\UseCase\AddMessage;

use App\Chat\Entity\Id;
use App\Chat\Repository\MessageRepositoryInterface;
use App\Chat\UseCase\AddMessage\Command;
use App\Chat\UseCase\AddMessage\Handler;
use App\Core\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddMessageTest extends KernelTestCase
{
    private EntityManagerInterface $em;

    protected function setUp()
    {
        parent::setUp();
        self::bootKernel();
        $this->em = static::$container->get('doctrine')->getManager();
        $this->em->getConnection()->beginTransaction();
        $this->em->getConnection()->setAutoCommit(false);
    }

    protected function tearDown(): void
    {
        $this->em->getConnection()->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testSuccess(): void
    {
        /** @var Handler $handler */
        $handler = self::$container->get(Handler::class);
        /** @var MessageRepositoryInterface $repo */
        $repo = self::$container->get(MessageRepositoryInterface::class);


        $id = Id::next();
        $content = 'Test content';
        $email = 'test@email.ru';

        $command = new Command($id);
        $command->content = $content;
        $command->authorEmail = $email;
        $command->isPublished = false;

        $handler->handle($command);

        try {
            $message = $repo->get($id);
        } catch (NotFoundException $e) {
            self::fail("The message was not properly saved");
        }

        self::assertEquals($content, $message->getContent());
        self::assertEquals($email, $message->getAuthor()->getEmail()->getValue());
        self::assertEquals("draft", $message->getStatus()->getValue());
    }

    // TODO Test with existing author
}
