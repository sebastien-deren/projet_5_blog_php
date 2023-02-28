<?php

namespace Blog\Form;

use Blog\DTO\User\RegisterDTO;
use Blog\Enum\RoleEnum;

class RegisterForm extends FormValidifier
{
    public function __construct(RegisterDTO $RegisterDTO)
    {
        parent::__construct($RegisterDTO);
    }
    protected function createDTO(array $data)
    {
        //we'd prefer to not encapsulate our function but if not this will trigger our linter
        if ($this->DTO instanceof RegisterDTO) {
            $this->DTO->mail = \htmlspecialchars($data['mail']);
            $this->DTO->password = $data["password"];
            $this->DTO->login = \htmlspecialchars($data["login"]);
            /*here we can update this by checking if the connected user is admin 
            and let him assign another role to a new "user".
            */
            $this->DTO->role = RoleEnum::USER;
            $this->DTO->firstName = \htmlspecialchars($data['firstname']);
            $this->DTO->lastName = \htmlspecialchars($data['lastname']);
        }
        else{
            throw new \Exception("We need a Register DTO, received".$this->DTO::class, 2);
        }
    }
    protected function checkingRequired(array $data)
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
