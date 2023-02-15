<?php

declare(strict_types=1);

namespace Blog\Service;

use Blog\Entity\User;
use Blog\DTO\AbstractDTO;
use Blog\DTO\User\LoginDTO;
use Blog\DTO\User\RegisterDTO;
use Doctrine\ORM\EntityManager;
use Blog\Exception\FormException;
use Blog\Service\Interface\Logger;
use Doctrine\ORM\EntityRepository;
use Blog\DTO\User\UserToDisplayDTO;
use Blog\Service\Interface\Creater;
use Blog\Service\Interface\Displayer;
use Doctrine\Persistence\ObjectRepository;
use Blog\Exception\UniqueKeyViolationException;


class UserService implements  Logger, Displayer //Updater, Deleter
{
    private static ?UserService $_userService =null;
    private User $user;
    private ObjectRepository|EntityRepository $repoUser;
    //pass it to private when refactoring register
    private function __construct(private EntityManager $entityManager)
    {
        $this->repoUser = $this->entityManager->getRepository(User::class);
    }
    public static function getService($entityManager){
        if (is_null(self::$_userService)){
            self::$_userService = new UserService($entityManager);
        }
        return self::$_userService;
    }
    public function create( $registerDTO)
    {
        if (!($registerDTO instanceof RegisterDTO)) {
            throw new \Exception("Internal Server Error", 500);
        }
        $this->uniqueKeyChecker([
            "mail" => $registerDTO->mail,
            "login" => $registerDTO->login
        ]);
        $this->user = new User($registerDTO);
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();
    }
    private function uniqueKeyChecker(array $KeyToCheck)
    {
        $uniqueKeyViolationMsg = "";
        foreach ($KeyToCheck as $columnName => $columnValue) {
            if ($this->entityManager->getRepository(User::class)->findOneBy([$columnName => $columnValue])) {
                $uniqueKeyViolationMsg = $uniqueKeyViolationMsg . " le " . $columnName . " est déjà utilisé.<br>";
            }
        }
        if ("" !== $uniqueKeyViolationMsg) {
            throw new UniqueKeyViolationException($uniqueKeyViolationMsg);
        }
    }


    public function log(LoginDTO $userToLog): int
    {
        try {
            $user = $this->repoUser->findOneBy([$userToLog->logintype->value => $userToLog->login]) ?? throw new \Exception();
            $user->checkPassword($userToLog->password) ?: throw new \Exception();
        } catch (\Exception $e) {
            throw new FormException("mot de passe ou login incorrect");
        }
        return $user->getId();
    }
    public function display(int $id): UserToDisplayDTO
    {
        $userDTO = new UserToDisplayDTO;
        $user = $this->entityManager->find(User::class, $id);
        $userDTO->firstname = $user->getFirstname();
        $userDTO->lastname = $user->getLastname();
        $userDTO->login = $user->getlogin();
        $userDTO->role = $user->getRole();
        return $userDTO;
    }
    public function getRole($id){
        return $this->entityManager->find(User::class,$id)->getRole();
    }
}
