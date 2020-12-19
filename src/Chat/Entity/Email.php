<?php
/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\Entity;

use Webmozart\Assert\Assert;

class Email
{
    private $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        Assert::email($value);
        $this->value = mb_strtolower(trim($value));
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Email $email): bool
    {
        return $email->getValue() === $this->getValue();
    }
}
