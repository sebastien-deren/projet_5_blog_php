<?php

namespace Blog\Service;

use Blog\Entity\User;
use Blog\DTO\AbstractDTO;
use Blog\DTO\User\RegisterDTO;
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
    public function create(AbstractDTO $registerDTO)
    {
        $this->user = new User($registerDTO);
        $this->entity->persist($this->user);
        $this->entity->flush();
    }
}
