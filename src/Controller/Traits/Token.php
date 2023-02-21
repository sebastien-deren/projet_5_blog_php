<?php

namespace Blog\Controller\Traits;

trait Token
{
    public function createToken(): string
    {
        // I don't know why i need that now it work perfectly before but well
        $csrfToken = \md5(\uniqid(\strval(\mt_rand()), true));
        $this->addFieldSession(['csrfToken' => $csrfToken]);
        $this->argument['csrfToken'] = $csrfToken;
        return  $csrfToken;
    }

}
