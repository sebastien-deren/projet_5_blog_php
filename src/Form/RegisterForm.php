<?php

namespace Blog\Form;

use Blog\DTO\User\RegisterDTO;
use Blog\Enum\RoleEnum;
use Blog\Form\Interface\FormValidifier;

class RegisterForm implements FormValidifier
{

    public function __construct(
        private RegisterDTO $RegisterDTO
    ) {
    }
    public function validify(array $data): RegisterDTO
    {
        $this->checkingRequired($data);
        $this->createRegisterDTO($data);
        return $this->RegisterDTO;
    }
    private function createRegisterDTO(array $data)
    {
        $this->RegisterDTO->mail = \htmlspecialchars($data['mail']);
        $this->RegisterDTO->password = $data["password"];
        $this->RegisterDTO->login = \htmlspecialchars($data["login"]);
        /*here we can update this by checking if the connected user is admin 
        and let him assign another role to a new "user".
        */
        $this->RegisterDTO->role = RoleEnum::USER;
        $this->RegisterDTO->firstName = \htmlspecialchars($data['firstname']);
        $this->RegisterDTO->lastName = \htmlspecialchars($data['lastname']);
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
    }
}
