<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\Repository;

use App\Chat\Entity\Author;
use App\Chat\Entity\Email;
use App\Core\Exception\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 */
class AuthorRepository extends ServiceEntityRepository implements AuthorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function getByEmail(Email $email): Author
    {
        if (!$author = $this->findOneBy(['email' => $email])) {
            throw new NotFoundException();
        }

        return $author;
    }

    public function add(Author $message): void
    {
        $this->getEntityManager()->persist($message);
        $this->getEntityManager()->flush();
    }
}
