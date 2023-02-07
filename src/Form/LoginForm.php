<?php

namespace Blog\Form;

use Blog\Enum\FieldType;
use Blog\DTO\User\LoginDTO;
use Blog\Form\FormValidifier;

class LoginForm extends FormValidifier
{

    protected function checkingRequired(array $data)
    {
        if (empty($data['login'])) {
            throw new \Exception("votre login est vide");
        }
        if (empty($data['password'])) {
            throw new \Exception("merci de rentrer un mot de passe");
        }
        if (FieldType::NULL === $this->checkLoginType($data['login'])) {
            throw new \Exception("votre login n'est pas correct");
        }
    }
    protected function createDTO(array $data)
    {

        $this->DTO->login = $data['login'];
        $this->DTO->password = $data['password'];
        $this->DTO->logintype = $this->checkLoginType($data['login']);
    }
    private function checkLoginType($login)
    {
        $dataType = FieldType::NULL;
        $dataType = ValidData::mail($login) ?? $dataType;
        $dataType = ValidData::login($login) ?? $dataType;
        return $dataType;
    }
}
