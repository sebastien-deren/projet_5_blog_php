<?php
namespace Blog\DTO\Entitie\User;

use Blog\Entity\User;
use Blog\Enum\RoleEnum;

class UserDTO{
    public string $firstname;
    public string $lastname;
    public string $login;
    public string $email;
    public RoleEnum $role;
    public function __construct(User $user)
    {
        $this->firstname = $user->getFirstname();
        $this->lastname = $user->getLastname();
        $this->login = $user->getlogin();
        $this->role = $user->getRole();
        $this->email =$user->getMail();
    }
    
}