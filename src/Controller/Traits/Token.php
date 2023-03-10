<?php

namespace Blog\Controller\Traits;

use Blog\Controller\Traits\Session;

trait Token
{
    private function createToken(): string
    {
        $csrfToken =\md5(\uniqid(\strval(\mt_rand()), true));
        $this->argument['csrfToken'] = $csrfToken;
        $this->addFieldSession(['csrfToken'=>$csrfToken]);
        return  $_SESSION['csrfToken'];
    }
}
