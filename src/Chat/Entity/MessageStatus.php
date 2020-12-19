<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\Entity;

use Webmozart\Assert\Assert;

class MessageStatus
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    private string $status;

    public function __construct(string $status)
    {
        Assert::inArray($status, [self::STATUS_PUBLISHED, self::STATUS_DRAFT]);
        $this->status = $status;
    }

    public function getValue(): string
    {
        return $this->status;
    }

    public static function draft(): self
    {
        return new self(self::STATUS_DRAFT);
    }

    public static function published(): self
    {
        return new self(self::STATUS_PUBLISHED);
    }
}
