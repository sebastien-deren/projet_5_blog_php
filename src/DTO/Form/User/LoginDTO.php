<?php

namespace Blog\DTO\Form\User;

use Blog\Enum\FieldType;

class LoginDTO
{
    public string $login;
    public string $password;
    public FieldType $logintype;
}
