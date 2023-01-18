<?php

namespace Blog\Service;

use Blog\Entity\User;
use Doctrine\ORM\EntityManager;
use Blog\DTO\User\UserCreateDTO;
use Blog\DTO\User\UserRegisterDTO;
use Blog\DTO\User\UserUpdateDTO;
use UserLoginDTO;

class UserService
{
    private User $user;
    public function __construct(private EntityManager $entity)
    {
    }
    public function registerUser(UserRegisterDTO $userToRegister)
    {
        $this->createUser($userToRegister->userCreate);
        $this->updateUser($userToRegister->userUpdate);
        $this->entity->persist($this->user);
        $this->entity->flush();
    }
    private function createUser(UserCreateDTO $userToCreate){
        $this->user = new User($userToCreate->login, $userToCreate->password, $userToCreate->mail,$userToCreate->role);
    }
    public function updateUser(UserUpdateDTO $userToUpdate)
    {
        $this->user->updateUser($userToUpdate->firstName,$userToUpdate->lastName);
    }

}
