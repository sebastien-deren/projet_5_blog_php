<?php

namespace Blog\DTO\Form\User;

use Blog\Enum\RoleEnum;

class RegisterDTO
{
    public string $login;
    public string $password;
    public string $mail;
    public RoleEnum $role;
    public string $firstName = "";
    public string $lastName = "";
}
