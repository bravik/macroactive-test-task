<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\Repository;

use App\Chat\Entity\Author;
use App\Chat\Entity\Email;
use App\Core\Exception\NotFoundException;

interface AuthorRepositoryInterface
{
    /**
     * @throws NotFoundException
     */
    public function getByEmail(Email $email): Author;

    public function add(Author $message): void;
}
