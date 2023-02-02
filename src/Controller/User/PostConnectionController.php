<?php

namespace Blog\Controller\User;

use Blog\Form\LoginForm;
use Blog\DTO\User\LoginDTO;
use Blog\Service\UserService;
use Blog\Controller\AbstractController;

class PostConnectionController extends AbstractController
{

    public function execute()
    {


        $formLogin = new LoginForm(new LoginDTO);
        $userService = new UserService($this->entityManager);
        $userToLog = $formLogin->validify($_POST);
        $userId = $userService->log($userToLog);
        $_SESSION['id'] = $userId;
        \header("location: /");
    }
}
