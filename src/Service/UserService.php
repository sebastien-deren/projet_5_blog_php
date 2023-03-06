<?php

declare(strict_types=1);

namespace Blog\Service;

use Blog\DTO\Entitie\User\UserDTO;
use Blog\Entity\User;
use Doctrine\ORM\EntityManager;
use Blog\DTO\Form\User\LoginDTO;
use Blog\Exception\FormException;
use Blog\Service\Interface\Logger;
use Doctrine\ORM\EntityRepository;
use Blog\DTO\User\UserToDisplayDTO;
use Blog\Enum\RoleEnum;
use Blog\Service\Interface\Creater;
use Blog\Service\Interface\Displayer;
use Doctrine\Persistence\ObjectRepository;
use Blog\Exception\UniqueKeyViolationException;
use Blog\Service\Interface\DisplayerInterface;
use Blog\Service\Interface\LoggerInterface;
use Exception;


class UserService 
{
    private static ?UserService $_userService = null;
    private User $user;
    private ObjectRepository|EntityRepository $repoUser;
    //pass it to private when refactoring register
    private function __construct(private EntityManager $entityManager)
    {
        $this->repoUser = $this->entityManager->getRepository(User::class);
    }
    public static function getService(EntityManager $entityManager): UserService
    {
        if (is_null(self::$_userService)) {
            self::$_userService = new UserService($entityManager);
        }
        return self::$_userService;
    }
    public function create(RegisterDTO $registerDTO): void
    {
        $this->uniqueKeyChecker([
            "mail" => $registerDTO->mail,
            "login" => $registerDTO->login
        ]);
        $this->user = new User($registerDTO);
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();
    }
    private function uniqueKeyChecker(array $KeyToCheck): void
    {
        $uniqueKeyViolationMsg = "";
        foreach ($KeyToCheck as $columnName => $columnValue) {
            if ($this->entityManager->getRepository(User::class)->findOneBy([$columnName => $columnValue])) {
                $uniqueKeyViolationMsg = $uniqueKeyViolationMsg . " le " . $columnName . " est déjà utilisé." . \PHP_EOL;
            }
        }
        if ("" !== $uniqueKeyViolationMsg) {
            throw new FormException($uniqueKeyViolationMsg);
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
    public function display(int $id): UserDTO
    {
        $user = $this->entityManager->find(User::class, $id);
        return new UserDTO($user);
    }
    public function getRole(int $id): RoleEnum
    {
        return $this->getUser($id)->getRole();
    }
    public function getUser(int $id): User
    {
        return $this->entityManager->find(User::class, $id) ?? throw new Exception("no User with id" . (string)$id);
    }
}
