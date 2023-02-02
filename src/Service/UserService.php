<?php

namespace Blog\Service;

use Blog\Entity\User;
use Blog\DTO\AbstractDTO;
use Blog\DTO\User\RegisterDTO;
use Blog\Exception\UniqueKeyViolationException;
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
        if(!($registerDTO instanceof RegisterDTO)){
            throw new \Exception("Internal Server Error",500);
        }
        $this->uniqueKeyChecker([
            "mail"=>$registerDTO->mail,
            "login"=>$registerDTO->login
        ]);
        $this->user = new User($registerDTO);
        $this->entity->persist($this->user);
        $this->entity->flush();
    }
    private function uniqueKeyChecker(array $KeyToCheck){
        $uniqueKeyViolationMsg="";
        foreach($KeyToCheck as $columnName => $columnValue){
            if ($this->entity->getRepository(User::class)->findOneBy([$columnName=>$columnValue])){
                $uniqueKeyViolationMsg= $uniqueKeyViolationMsg . " le ".$columnName." est déjà utilisé.";
            }
        }
        if("" !==$uniqueKeyViolationMsg){
            throw new UniqueKeyViolationException($uniqueKeyViolationMsg);
        }
    }
}
