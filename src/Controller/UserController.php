<?php

namespace Blog\Controller;

use Blog\Entity\User;

class UserController
{
    private User $user;
    public function addUser(Array $property):User
    {
        $this->user =new User;
        $this->user->setFirstname($property["firstname"]);
        $this->user->setLastname($property["lastname"]);
        $this->user->setMail($property["mail"]);
        $this->user->setRole($property["role"]);
        $this->user->setPassword($property["password"]);
        $this->user->setLogin(\strval(\rand(0,200)));
        return $this->user;
    }
}
