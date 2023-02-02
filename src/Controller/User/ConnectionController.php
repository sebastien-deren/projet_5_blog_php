<?php

namespace Blog\Controller\User;

use Blog\Controller\AbstractController;
use Blog\Controller\Interface\Controller;

class ConnectionController extends AbstractController
{

    public function execute()
    {
        return "on arrive sur la page de connection";
    }
}
