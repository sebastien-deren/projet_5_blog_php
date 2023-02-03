<?php
namespace Blog\Controller\Traits;

use Blog\Controller\Traits\Session;

trait Token {
    public function create():string{
        Session::addElement(['token' => \md5(\uniqid(\strval(\mt_rand()), true))]);
        return  $_SESSION['token'];
    }
}