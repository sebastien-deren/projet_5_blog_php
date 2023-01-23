<?php

namespace Blog\Form;

use Blog\Enum\RoleEnum;
use Blog\DTO\User\UserCreateDTO;
use Blog\Form\Interface\FormValidifier;

class UserRegisterForm implements FormValidifier
{

    public function __construct(
        private UserCreateDTO $userDTO
    ) {
    }
    public function validify(array $data): UserCreateDTO
    {
        $this->arrayToObjectCreate($data);
        $this->arrayToObjectUpdate($data);
        return $this->userDTO;
    }
    private function arrayToObjectCreate(array $data)
    {
        $this->checkingRequired($data);
        $this->userDTO->userRegisterDTO->mail = \htmlspecialchars($data['mail']);
        $this->userDTO->userRegisterDTO->password = $data["password"];
        $this->userDTO->userRegisterDTO->login = \htmlspecialchars($data["login"]);
        $this->userDTO->userRegisterDTO->role = RoleEnum::From($data['role']);
    }
    private function arrayToObjectUpdate(array $data)
    {
        if ($data['firstname']) {
            $this->userDTO->userUpdateDTO->firstName = \htmlspecialchars($data['firstname']);
        }
        if ($data['lastname']) {
            $this->userDTO->userUpdateDTO->lastName = \htmlspecialchars($data['lastname']);
        }
    }
    private function checkingRequired($data)
    {
        if (empty($data["login"])) {
            throw new \UnexpectedValueException('le nom d\'utilisateur n\'ai pas rempli');
        }
        if (empty($data["password"]) || empty($data["passwordverify"])) {
            throw new \UnexpectedValueException("le mot de passe n\'ai pas rempli");
        }
        if (!($data["password"] === $data["passwordverify"])) {
            throw new \UnexpectedValueException('deux mots de passe ne corresponde pas');
        }
        if (empty($data['mail'])) {
            throw new \InvalidArgumentException('le mail n\'ai pas rempli');
        }
        if (empty($data['role'])) {
            throw new \InvalidArgumentException('le role n\'ai pas rempli');
        }
        if (!RoleEnum::tryFrom($data['role'])) {
            throw new \InvalidArgumentException("le role ne convient pas");
        }
    }
}
