<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="chat__messages")
 */
class Message implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="chat__id")
     */
    private Id $id;

    /** @ORM\Column(type="string") */
    private string $content;

    /** @ORM\Column(type="chat__message_status") */
    private MessageStatus $status;

    /** @ORM\ManyToOne(targetEntity="Author") */
    private Author $author;

    public function __construct(Id $id, string $content, Author $author, MessageStatus $status)
    {
        Assert::notEmpty($content);
        $this->id = $id;
        $this->content = $content;
        $this->author = $author;
        $this->status = $status;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getStatus(): MessageStatus
    {
        return $this->status;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id->getValue(),
            'content' => $this->content,
            'author' => $this->author->getEmail()->getValue(),
            'status' => $this->status->getValue(),
        ];
    }
}
