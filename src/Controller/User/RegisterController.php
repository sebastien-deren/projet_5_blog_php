<?php

namespace Blog\Controller\User;

use Blog\Form\RegisterForm;
use Blog\Service\UserService;
use Blog\DTO\User\RegisterDTO;
use Blog\Controller\AbstractController;

class RegisterController extends AbstractController
{

    public function execute():?string
    {
        $this->addFieldSession(['token' => \md5(\uniqid(\mt_rand(), true))]);
        $this->argument['csrfToken'] = $_SESSION['token'];
        return $this->twig->render('@user/register.html.twig', $this->argument);
    }
    private function validateFormIntoDTO($data): RegisterDTO
    {
        $formValidifier = new RegisterForm(new RegisterDTO);
        return $formValidifier->validify($data);
    }
    private function createUser(RegisterDTO $registerDTO)
    {
        $userService = new UserService($this->entityManager);
        $userService->create($registerDTO);
    }
}
