<?php

namespace Blog\Form;

use Blog\DTO\User\LoginDTO;
use Blog\Form\Interface\FormValidifier;

class LoginForm
{
    public function  __construct(private LoginDTO $loginDTO)
    {
    }
    public function validify(array $data): LoginDTO
    {
        $this->checkLoginData($data);
        $this->createLoginDTO($data);
        return $this->loginDTO;
    }
    private function checkLoginData(array $data)
    {
        if (empty($data['login'])) {
            throw new \Exception("merci de rentrer un login");
        }
        if (empty($data['password'])) {
            throw new \Exception("merci de rentrer un mot de passe");
        }
        if (\filter_var($data['login'], \FILTER_VALIDATE_EMAIL)) {
            $this->loginDTO->logintype = 'mail';
        } elseif (!\strchr($data['login'], ' ')) {
            $this->loginDTO->logintype = "login";
        } else {
            throw new \Exception("votre login n'est pas correct, merci de taper un email valide, ou votre username sans espace");
        }
    }
    private function createLoginDTO(array $data)
    {
        $this->loginDTO->login = $data['login'];
        $this->loginDTO->password = $data['password'];
    }
}
