<?php
namespace Blog\Model\Form;

use Blog\DTO\User\UserLoginDTO;

class LoginFormModel{

    public function arrayToObjectUserLogin(array $data):UserLoginDTO
    {
        if(empty($data['login'])){
            throw new \Exception("veuillez remplir votre login");
        }
        if(empty($data['password'])){
            throw new \Exception("veuillez remplir votre MDP");
        }
        $userLogin = new UserLoginDTO;
        $userLogin->login=\htmlspecialchars($data['login']);
        $userLogin->password=($data['password']);
        return $userLogin;

    }

}