<?php

namespace Blog\Service;

use Blog\Entity\User;
use Blog\DTO\AbstractDTO;
use Blog\DTO\User\UserCreateDTO;
use Blog\DTO\User\UserUpdateDTO;
use Blog\DTO\User\UserRegisterDTO;
use Blog\Service\Interface\Creater;
use Doctrine\ORM\EntityManagerInterface;

class UserService implements Creater //, Updater, Deleter
{
    private User $user;
    public function __construct(private EntityManagerInterface $entity)
    {
    }
    public function create(AbstractDTO $objectToCreate)
    {
        $this->createUser($objectToCreate);
    }
    public function createUser(UserCreateDTO $userToCreate)
    {
        $this->register($userToCreate->userRegisterDTO);
        $this->updateUser($userToCreate->userUpdateDTO);
        $this->entity->persist($this->user);
        $this->entity->flush();
    }
    private function register(UserRegisterDTO $userToCreate)
    {
        $this->user = new User($userToCreate->login, $userToCreate->password, $userToCreate->mail, $userToCreate->role);
    }
    public function updateUser(UserUpdateDTO $userToUpdate)
    {
        $this->user->updateUser($userToUpdate->firstName, $userToUpdate->lastName);
    }
}
