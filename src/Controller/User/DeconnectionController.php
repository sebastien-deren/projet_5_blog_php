<?php

namespace Blog\Controller\User;

use Blog\Controller\Abstracts\AbstractController;


class DeconnectionController extends AbstractController
{
    public function execute():?string
    {
        unset($_SESSION['id']);
        \header('location: /');
        return null;
    }
}
