<?php

namespace Blog\Controller\Traits;

trait Token
{
    public function createToken(): string
    {
        $csrfToken = \md5(\uniqid(\strval(\mt_rand()), true));
        $this->addFieldSession(['token' => $csrfToken]);
        $this->argument['csrfToken'] = $csrfToken;
        return  $csrfToken;
    }
}
