<?php

namespace Blog\Controller\Traits;

class Session
{
    /**
     * addElement
     *
     * @param array<string> $data the element added to $_SESSION
     *
     * @return void
     */

     
    public static function addElement(array $data): void
    {
        $_SESSION['ipAddress'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION = \array_merge($data, $_SESSION);
    }
}
