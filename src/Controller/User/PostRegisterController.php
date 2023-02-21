<?php

namespace Blog\Controller\User;

use Exception;
use Blog\Form\RegisterForm;
use Blog\Service\UserService;
use Blog\DTO\User\RegisterDTO;
use Blog\Controller\Abstracts\AbstractController;


class PostRegisterController extends AbstractController{
    public function execute():?string
    {
        try{
            $registerDTO = $this->validateFormIntoDTO($_POST);
            
            $this->CreateUser($registerDTO);
        }
        catch(\Exception $e){
            throw new Exception($e->getMessage(),$e->getCode());
        }
        
        header("location: /connection");
        return null;

    }
    private function validateFormIntoDTO($data): RegisterDTO
    {
        $formValidifier = new RegisterForm(new RegisterDTO);
        return $formValidifier->validify($data);
    }
    private function createUser(RegisterDTO $registerDTO)
    {
        $userService = UserService::getService($this->entityManager);
        $userService->create($registerDTO);
    }
}
