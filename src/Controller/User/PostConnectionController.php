<?php

namespace Blog\Controller\User;

use Blog\DTO\User\LoginDTO;
use Blog\Form\User\LoginForm;
use Blog\Service\UserService;
use Blog\Controller\AbstractController;
use Blog\Exception\FormException;

class PostConnectionController extends ConnectionController
{

    public function execute():?string
    {

        try{
        $formLogin = new LoginForm(new LoginDTO,$_POST);
        $userService = UserService::getService($this->entityManager);
        $userToLog = $formLogin->validify();
        $userId = $userService->log($userToLog);
        $_SESSION['id'] = $userId;
        }
        catch(FormException $e){
            $this->argument['error']=$e;
            return parent::execute();
        }
        \header("location: /");
        return null;
    }
}
