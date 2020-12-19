<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\Doctrine;

use App\Chat\Entity\MessageStatus;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class MessageStatusType extends StringType
{
    public const NAME = 'chat__message_status';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof MessageStatus ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?MessageStatus
    {
        return !empty($value) ? new MessageStatus($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
