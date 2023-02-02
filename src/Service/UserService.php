<?php

namespace Blog\Service;

use Exception;
use Blog\Entity\User;
use Blog\DTO\AbstractDTO;
use Blog\DTO\User\LoginDTO;
use Blog\DTO\User\RegisterDTO;
use Doctrine\ORM\EntityManager;
use Blog\Service\Interface\Logger;
use Doctrine\ORM\EntityRepository;
use Blog\DTO\User\UserToDisplayDTO;
use Blog\Service\Interface\Creater;
use Blog\Service\Interface\Displayer;
use Doctrine\Persistence\ObjectRepository;
use Blog\Exception\UniqueKeyViolationException;


class UserService implements Creater, Logger, Displayer //Updater, Deleter
{
    private User $user;
    private ObjectRepository|EntityRepository $repoUser;
    public function __construct(private EntityManager $entityManager)
    {
        $this->repoUser = $this->entityManager->getRepository(User::class);
    }
    public function create(AbstractDTO $registerDTO)
    {
        if(!($registerDTO instanceof RegisterDTO)){
            throw new \Exception("Internal Server Error",500);
        }
        $this->uniqueKeyChecker([
            "mail"=>$registerDTO->mail,
            "login"=>$registerDTO->login
        ]);
        $this->user = new User($registerDTO);
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();
    }

    private function uniqueKeyChecker(array $KeyToCheck){
        $uniqueKeyViolationMsg="";
        foreach($KeyToCheck as $columnName => $columnValue){
            if ($this->entityManager->getRepository(User::class)->findOneBy([$columnName=>$columnValue])){
                $uniqueKeyViolationMsg= $uniqueKeyViolationMsg . " le ".$columnName." est déjà utilisé.";
            }
        }
        if("" !==$uniqueKeyViolationMsg){
            throw new UniqueKeyViolationException($uniqueKeyViolationMsg);
        }
    }

    public function log(LoginDTO $userToLog):int{
        $loginType = \filter_var($userToLog->login,\FILTER_VALIDATE_EMAIL)?"mail":"login";
        $user = $this->repoUser->findOneBy([$loginType =>$userToLog->login]);
        $user->checkPassword($userToLog->password)?:throw new Exception("password/login is not correct");
        return $user->getId();
    }
    public function display(int $id):UserToDisplayDTO
    {
        $userDTO = new UserToDisplayDTO;
        $user = $this->entityManager->find(User::class,$id);
        $userDTO->firstname = $user->getFirstname();
        $userDTO->lastname = $user->getLastname();
        $userDTO->role =$user->getRole();
        return $userDTO;

    }
}
