<?php
namespace Blog\DTO\User;

use Blog\Enum\RoleEnum;

class UserCreateDTO{
    public string $login;
    public string $password;
    public string $mail;
    public RoleEnum $role;
}