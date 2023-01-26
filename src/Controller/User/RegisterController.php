<?php

namespace Blog\Controller\User;

use Blog\Service\UserService;
use Blog\Controller\Controller;
use Blog\Exception\FormException;
use Blog\Model\Form\RegisterFormModel;
use Blog\Controller\AbstractController;

class RegisterController extends AbstractController
{
    public function render()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userService = new UserService($this->entityManager);
            $registerModel = new RegisterFormModel;
            try {
                $user = $registerModel->ArrrayToObjectUserRegister($_POST);
                $userService->registerUser($user);
                //TODO change it to /connection when connection issue is done
                header("location: /");
            } catch (FormException $e) {
                //TODO make a reusable template to display error in different pages
                echo $this->twig->render('@user/register.html.twig', ['error' => $e]);
            }
        } else {
            echo $this->twig->render('@user/register.html.twig');
        }
    }
}
