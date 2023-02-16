<?php
namespace Blog\Controller\Traits;

use Blog\Controller\Traits\Session;

trait Token {
    public function createToken():string{
        $this->addElement(['token' => \md5(\uniqid(\strval(\mt_rand()), true))]);
        return  $_SESSION['token'];
    }
}