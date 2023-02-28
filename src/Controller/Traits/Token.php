<?php
namespace Blog\Controller\Traits;

use Blog\Controller\Traits\Session;

trait Token
{

    /**
     * create a csrf token used when an user input is required
     *
     * @return string
     */

     
    public function createToken():string
    {
        Session::addElement(['token' => \md5(\uniqid(\strval(\mt_rand()), true))]);
        return  $_SESSION['token'];
    }
}