<?php

namespace Blog\Controller\User;

use Blog\Controller\AbstractController;

class RegisterController extends AbstractController
{

    public function execute():?string
    {
        $this->addFieldSession(['token' => \md5(\uniqid(\mt_rand(), true))]);
        $this->argument['csrfToken'] = $_SESSION['token'];
        return $this->twig->render('@user/register.html.twig', $this->argument);
    }
}
