<?php

namespace Blog\Model\Form;

use Blog\Enum\RoleEnum;
use Blog\DTO\User\UserUpdateDTO;
use Blog\DTO\User\UserRegisterDTO;

class RegisterFormModel
{
    private UserRegisterDTO $userDTO;
    public function ArrrayToObjectUserRegister(array $data): UserRegisterDTO
    {
        \var_dump($data);
        $this->userDTO =new UserRegisterDTO();
        $this->ArrayToObjectUserCreate($data);
        if(count(\array_filter($data))>4){
            $this->userDTO->userUpdate = new UserUpdateDTO();
            $this->ArrayToObjectUserUpdate($data);
        }
        \var_dump($this->userDTO);
        return $this->userDTO;
    }
    private function ArrayToObjectUserCreate(array $data){
        if (empty($data["login"])) {
            throw new \UnexpectedValueException('le nom d\'utilisateur n\'ai pas rempli');
        }
        $this->userDTO->userCreate->login=\htmlspecialchars($data["login"]);
        if (empty($data["password"]) || empty($data["passwordverify"])) {
            throw new \UnexpectedValueException("le mot de passe n\'ai pas rempli");
        }
        if (!($data["password"] === $data["passwordverify"])) {
            throw new \UnexpectedValueException('deux mots de passe ne corresponde pas');
        }
        $this->userDTO->userCreate->password= $data["password"];
        if (empty($data['mail'])) {
            throw new \InvalidArgumentException('le mail n\'ai pas rempli');
        }
        $this->userDTO->userCreate->mail=\htmlspecialchars($data['mail']);
        if(empty($data['role'])){
            throw new \InvalidArgumentException('le role n\'ai pas rempli');
        }
        $role = RoleEnum::tryFrom($data['role'])?:throw new \InvalidArgumentException("le role ne convient pas");
        $this->userDTO->userCreate->role= $role;
    }
    private function ArrayToObjectUserUpdate(array $data){
            $this->userDTO->userUpdate->firstName=\htmlspecialchars($data['firstname']);            
            $this->userDTO->userUpdate->lastName=\htmlspecialchars($data['lastname']);

    }
}
