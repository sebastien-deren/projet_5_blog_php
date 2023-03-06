<?php

namespace Blog\Form\User;

use Blog\Enum\FieldType;
use Blog\DTO\Form\User\LoginDTO;
use Blog\Exception\FormException;
use Blog\Form\Abstracts\ValidData;
use Blog\Form\Abstracts\FormValidifier;

class LoginForm extends FormValidifier
{

    public function __construct(LoginDTO $DTO, array $data)
    {
        $this->DTO = $DTO;
        parent::__construct($data);
    }
    protected function checkingRequired(): void
    {
        if (empty($this->data['login'])) {
            throw new FormException("votre login est vide");
        }
        if (empty($this->data['password'])) {
            throw new FormException("merci de rentrer un mot de passe");
        }
        if (FieldType::NULL === $this->checkLoginType($this->data['login'])) {
            throw new FormException("votre login n'est pas correct");
        }
    }
    protected function createDTO(): void
    {

        $this->DTO->login = $this->data['login'];
        $this->DTO->password = $this->data['password'];
        $this->DTO->logintype = $this->checkLoginType($this->data['login']);
    }
    private function checkLoginType(string $login): FieldType
    {
        $dataType = FieldType::NULL;
        $dataType = ValidData::mail($login) ?? $dataType;
        $dataType = ValidData::login($login) ?? $dataType;
        return $dataType;
    }
}
