<?php

namespace Blog\Service;

use Blog\Entity\User;
use Doctrine\ORM\EntityManager;
use Blog\DTO\User\UserCreateDTO;
use Blog\DTO\User\UserLoginDTO;
use Blog\DTO\User\UserRegisterDTO;
use Blog\DTO\User\UserUpdateDTO;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Exception;

class UserService
{
    private User $user;
    private ObjectRepository|EntityRepository $repoUser;
    public function __construct(private EntityManager $entityManager)
    {
        $this->repoUser = $this->entityManager->getRepository(User::class);
    }
    public function registerUser(UserRegisterDTO $userToRegister)
    {
        $this->createUser($userToRegister->userCreate);
        $this->updateUser($userToRegister->userUpdate);
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();
    }
    private function createUser(UserCreateDTO $userToCreate){
        $this->user = new User($userToCreate->login, $userToCreate->password, $userToCreate->mail,$userToCreate->role);
    }
    public function updateUser(UserUpdateDTO $userToUpdate)
    {
        $this->user->updateUser($userToUpdate->firstName,$userToUpdate->lastName);
    }
    public function loginUser(UserLoginDTO $userToLog):int{
        $loginType = \filter_var($userToLog->login,\FILTER_VALIDATE_EMAIL)?"mail":"login";
        $user = $this->repoUser->findOneBy([$loginType =>$userToLog->login]);
        $user->checkPassword($userToLog->password)?:throw new Exception("password/login is not correct");
        return $user->getId();
    }
}
