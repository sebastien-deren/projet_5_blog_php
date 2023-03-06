<?php

namespace Blog\DTO\User;

use Blog\Enum\FieldType;
use Blog\DTO\AbstractDTO;

class LoginDTO extends AbstractDTO
{
    public string $login;
    public string $password;
    public FieldType $logintype;
}
