<?php
namespace Blog\DTO\User;
class UserRegisterDTO{
    public UserCreateDTO $userCreate;
    public UserUpdateDTO|null $userUpdate;
    public function __construct()
    {
        $this->userCreate =new UserCreateDTO();
    }
}