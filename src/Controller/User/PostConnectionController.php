<?php

namespace Blog\Controller\User;

use Blog\DTO\User\LoginDTO;
use Blog\Form\User\LoginForm;
use Blog\Service\UserService;
use Blog\Controller\AbstractController;

class PostConnectionController extends AbstractController
{

    public function execute():?string
    {


        $formLogin = new LoginForm(new LoginDTO,$_POST);
        $userService = UserService::getService($this->entityManager);
        $userToLog = $formLogin->validify();
        $userId = $userService->log($userToLog);
        $_SESSION['id'] = $userId;
        \header("location: /");
        return null;
    }
}
