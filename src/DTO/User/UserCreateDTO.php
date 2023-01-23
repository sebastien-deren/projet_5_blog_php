<?php

namespace Blog\DTO\User;

use Blog\DTO\AbstractDTO;

class UserCreateDTO extends AbstractDTO{
    public function __construct(public UserRegisterDTO $userRegisterDTO, public UserUpdateDTO $userUpdateDTO)
    {
    }
}
