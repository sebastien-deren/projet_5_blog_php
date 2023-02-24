<?php

namespace Blog\Controller\User;

use Blog\Service\UserService;
use Blog\DTO\User\RegisterDTO;
use Blog\Form\User\RegisterForm;
use Blog\Exception\FormException;


class PostRegisterController extends RegisterController{
    public function execute():?string
    {
        try{
            $registerDTO = $this->validateFormIntoDTO($_POST);
            $this->CreateUser($registerDTO);
        }
        catch(FormException $e){
            $this->argument['error']= $e;
            return parent::execute();
        }
        
        header("location: /connection");
        return null;

    }
    private function validateFormIntoDTO($data): RegisterDTO
    {
        $formValidifier = new RegisterForm(new RegisterDTO,$data);
        return $formValidifier->validify();
    }
    private function createUser(RegisterDTO $registerDTO)
    {
        $userService = UserService::getService($this->entityManager);
        $userService->create($registerDTO);
    }
}
