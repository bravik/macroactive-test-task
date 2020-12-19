<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="chat__authors")
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\Column(type="chat__id")
     */
    private Id $id;

    /** @ORM\Column(type="chat__email", unique=true) */
    private Email $email;

    public function __construct(Id $id, Email $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
