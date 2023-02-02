<?php

namespace Blog\Controller\User;

use Blog\Form\RegisterForm;
use Blog\Service\UserService;
use Blog\DTO\User\RegisterDTO;
use Blog\Exception\FormException;
use Blog\Controller\AbstractController;
use Blog\Controller\Interface\ReceivingPost;
use Blog\Exception\UniqueKeyViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;

class PostRegisterController extends AbstractController{
    public function execute()
    {
        try{
            $registerDTO = $this->validateFormIntoDTO($_POST);
            
            $this->CreateUser($registerDTO);
        }
        catch(\Exception $e){
            throw new Exception($e->getMessage(),$e->getCode());
        }
        
        header("location: /connection");
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
