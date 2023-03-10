<?php

namespace Blog\DTO\Entity\User;

use Blog\Entity\User;
use Blog\Enum\RoleEnum;

class UserDTO
{
    public string $firstname;
    public string $lastname;
    public string $login;
    public string $email;
    public int $id;
    public RoleEnum $role;
    public function __construct(User $user)
    {
        $this->firstname = $user->getFirstname();
        $this->lastname = $user->getLastname();
        $this->login = $user->getlogin();
        $this->role = $user->getRole();
        $this->id= $user->getId();
        $this->email = $user->getMail();
    }
}
