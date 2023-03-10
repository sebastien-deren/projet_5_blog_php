<?php

namespace Blog\Controller\User\Register;

use Blog\Controller\AbstractController;
use Blog\Controller\Traits\Token;

class RegisterController extends AbstractController
{
    use Token;
    public function execute():?string
    {
        $this->createToken();
        return $this->twig->render('@user/register.html.twig', $this->argument);
    }
}
