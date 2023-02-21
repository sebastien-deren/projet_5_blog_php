<?php

namespace Blog\Controller\User;

use Blog\Form\LoginForm;
use Blog\DTO\User\LoginDTO;
use Blog\Service\UserService;
use Blog\Controller\Abstracts\AbstractController;

class PostConnectionController extends AbstractController
{

    public function execute(): ?string
    {
        $formLogin = new LoginForm(new LoginDTO);
        $userService = UserService::getService($this->entityManager);
        $userToLog = $formLogin->validify($_POST);
        $userId = $userService->log($userToLog);
        $_SESSION['id'] = $userId;
        \header("location: /");
        return null;
    }
}
