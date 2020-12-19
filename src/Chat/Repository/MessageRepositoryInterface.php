<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\Repository;

use App\Chat\Entity\Id;
use App\Chat\Entity\Message;

interface MessageRepositoryInterface
{
    public function get(Id $id): Message;

    /** @return Message[] */
    public function findAll(): array;

    public function add(Message $message): void;
}
