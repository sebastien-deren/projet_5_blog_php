<?php

namespace Blog\Controller\User\Register;

use Blog\Service\UserService;
use Blog\Form\User\RegisterForm;
use Blog\Exception\FormException;
use Blog\DTO\Form\User\RegisterDTO;


class PostRegisterController extends RegisterController{
    public function execute():?string
    {
        try{
            $registerDTO = $this->validateFormIntoDTO($_POST);
            $this->createUser($registerDTO);
        }
        catch(FormException $e){
            $this->argument['error']= $e;
            return parent::execute();
        }
        
        header("location: /connection");
        return null;

    }
    private function validateFormIntoDTO(array $data): RegisterDTO
    {
        $formValidifier = new RegisterForm(new RegisterDTO,$data);
        return $formValidifier->validify();
    }
    private function createUser(RegisterDTO $registerDTO) : void
    {
        $userService = UserService::getService($this->entityManager);
        $userService->create($registerDTO);
    }
}
