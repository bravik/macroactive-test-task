<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\ReadModel\TopAuthors;

use App\Chat\Entity\MessageStatus;
use Doctrine\DBAL\Connection;

class Fetcher
{
    private Connection $connection;
    private const TABLE_AUTHORS = 'chat__authors';
    private const TABLE_MESSAGES = 'chat__messages';

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /** @return View[] */
    public function getTopAuthors(int $limit = 10): array
    {
        $query = $this->connection->createQueryBuilder()
            ->select(
                'a.email',
                'COUNT(*) as messagesCount'
            )
            ->from(self::TABLE_MESSAGES, 'm')
            ->leftJoin('m', self::TABLE_AUTHORS, 'a', 'm.author_id = a.id')
            ->where('m.status = "' . MessageStatus::STATUS_PUBLISHED . '"')
            ->groupBy('a.id')
            ->setMaxResults($limit)
            ->execute()
            ;

        $result = $query->fetchAllAssociative();

        $views = [];
        foreach ($result as $row) {
            $views[] = View::fromArray($row);
        }

        return $views;
    }

    /** @return View[] */
    public function getTopWriters(int $limit = 10): array
    {
        $query = $this->connection->createQueryBuilder()
            ->select(
                'a.email',
                'COUNT(*) as messagesCount'
            )
            ->from(self::TABLE_MESSAGES, 'm')
            ->leftJoin('m', self::TABLE_AUTHORS, 'a', 'm.author_id = a.id')
            ->groupBy('a.id')
            ->setMaxResults($limit)
            ->execute()
        ;

        $result = $query->fetchAllAssociative();

        $views = [];
        foreach ($result as $row) {
            $views[] = View::fromArray($row);
        }

        return $views;
    }
}
