<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\UseCase\AddMessage;

use App\Chat\Entity\Id;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public Id $id;

    /**
     * @Assert\NotBlank
     */
    public ?string $content = null;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    public ?string $authorEmail = null;

    /**
     * @Assert\NotNull
     */
    public ?bool $isPublished = null;

    public function __construct(Id $id)
    {
        $this->id = $id;
    }
}
