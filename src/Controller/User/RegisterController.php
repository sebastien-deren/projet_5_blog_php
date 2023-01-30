<?php

namespace Blog\Controller\User;

use Blog\Form\RegisterForm;
use Blog\Service\UserService;
use Blog\DTO\User\RegisterDTO;
use Blog\Exception\FormException;
use Blog\Controller\AbstractController;
use Blog\Controller\Interface\ReceivingPost;

class RegisterController extends AbstractController implements ReceivingPost
{
    public function execute()
    {
        try {
            $registerDTO = $this->validateFormIntoDTO($_POST);
            $this->CreateUser($registerDTO);

            //TODO change it to /connection when connection issue is done
            header("location: /");
        } catch (FormException $e) {
            //TODO make a reusable template to display error in different pages
            echo ['@user/register.html.twig', ['error' => $e]];
        }
    }
    public function render()
    {
        $this->addFieldSession(['token'=> \md5(\uniqid(\mt_rand(),true))]);
        $this->argument['csrfToken']=$_SESSION['token'];
        echo $this->twig->render('@user/register.html.twig',$this->argument);
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
