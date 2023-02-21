<?php

namespace Blog\Controller\User;

use Blog\Controller\Traits\Token;
use Blog\Controller\Abstracts\AbstractController;

class RegisterController extends AbstractController
{

    use Token;
    public function execute():?string
    {
        $this->createToken();
        return $this->twig->render('@user/register.html.twig', $this->argument);
    }
}
