<?php

namespace Blog\DTO\User;

use Blog\Enum\RoleEnum;
use Blog\DTO\AbstractDTO;

class RegisterDTO extends AbstractDTO
{
    public string $login;
    public string $password;
    public string $mail;
    public RoleEnum $role;
    public string $firstName = "";
    public string $lastName = "";
}
