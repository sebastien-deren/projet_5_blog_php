<?php

namespace Blog\Controller\User;

use Blog\Controller\Controller;
use Blog\Controller\AbstractController;
use Blog\Controller\ControllerInterface;

class DeconnectionController extends AbstractController
{
    public function execute():?string
    {
        unset($_SESSION['id']);
        \header('location: /');
        return null;
    }
}
