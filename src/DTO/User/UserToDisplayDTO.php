<?php
namespace Blog\DTO\User;

use Blog\Enum\RoleEnum;

class UserToDisplayDTO{
    public string $firstname;
    public string $lastname;
    public RoleEnum $role;
    
}