<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\UseCase\AddMessage;

use App\Chat\Entity\Author;
use App\Chat\Entity\Email;
use App\Chat\Entity\Id;
use App\Chat\Entity\Message;
use App\Chat\Entity\MessageStatus;
use App\Chat\Repository\AuthorRepositoryInterface;
use App\Chat\Repository\MessageRepositoryInterface;
use App\Core\Exception\NotFoundException;

class Handler
{
    private MessageRepositoryInterface $messageRepository;
    private AuthorRepositoryInterface $authorRepository;

    public function __construct(
        MessageRepositoryInterface $messageRepository,
        AuthorRepositoryInterface $authorRepository
    ) {
        $this->messageRepository = $messageRepository;
        $this->authorRepository = $authorRepository;
    }

    public function handle(Command $command): void
    {
        // Get existing or create new author
        try {
            $author = $this->authorRepository->getByEmail(
                new Email($command->authorEmail)
            );
        } catch (NotFoundException $e) {
            $author = new Author(Id::next(), new Email($command->authorEmail));
            $this->authorRepository->add($author);
        }

        $message = new Message(
            $command->id,
            $command->content,
            $author,
            $command->isPublished ? MessageStatus::published() : MessageStatus::draft()
        );

        $this->messageRepository->add($message);
    }
}
