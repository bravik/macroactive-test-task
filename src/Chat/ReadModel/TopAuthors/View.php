<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\ReadModel\TopAuthors;

class View
{
    public string $email;
    public int $messagesCount;

    public static function fromArray(array $array): View
    {
        $view = new self();
        $view->email = $array['email'];
        $view->messagesCount =(int) $array['messagesCount'];

        return $view;
    }
}
