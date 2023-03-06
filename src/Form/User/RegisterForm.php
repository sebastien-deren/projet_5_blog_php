<?php

namespace Blog\Form\User;

use Blog\Enum\RoleEnum;
use Blog\Exception\FormException;
use Blog\DTO\Form\User\RegisterDTO;
use Blog\Form\Abstracts\FormValidifier;

class RegisterForm extends FormValidifier
{
    public function __construct(RegisterDTO $RegisterDTO, array $data)
    {
        $this->DTO = $RegisterDTO;
        parent::__construct($data);
    }
    protected function createDTO(): void
    {
        //we'd prefer to not encapsulate our function but if not this will trigger our linter
        $this->DTO->mail = \htmlspecialchars($this->data['mail']);
        $this->DTO->password = $this->data["password"];
        $this->DTO->login = \htmlspecialchars($this->data["login"]);
        /*here we can update this by checking if the connected user is admin 
        and let him assign another role to a new "user".
        */
        $this->DTO->role = RoleEnum::USER;
        $this->DTO->firstName = \htmlspecialchars($this->data['firstname']);
        $this->DTO->lastName = \htmlspecialchars($this->data['lastname']);
    }
    protected function checkingRequired(): void
    {
        if (empty($this->data["login"])) {
            throw new FormException('le nom d\'utilisateur n\'ai pas rempli');
        }
        if (empty($this->data["password"]) || empty($this->data["passwordverify"])) {
            throw new FormException("le mot de passe n\'ai pas rempli");
        }
        if (!($this->data["password"] === $this->data["passwordverify"])) {
            throw new FormException('deux mots de passe ne corresponde pas');
        }
        if (empty($this->data['mail'])) {
            throw new FormException('le mail n\'ai pas rempli');
        }
    }
}
