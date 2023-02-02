<?php

declare(strict_types=1);

namespace Blog\Entity;

use Blog\DTO\User\RegisterDTO;
use Blog\Enum\RoleEnum;
use Doctrine\ORM\Mapping\Id;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\Common\Collections\Collection;

//anemic class with setter & getter for all attribute except id (only getter)
#[Entity]
class User
{
    #[Id]
    #[Column(type: TYPES::INTEGER, updatable: false, unique: true)]
    #[GeneratedValue()]
    private int $id;
    #[Column()]
    private string $password;
<<<<<<< HEAD
    #[Column(unique:true, length:255)]
    private string $login;
    #[Column(type: Types::STRING, length:255, nullable:true)]
    private string $firstname;
    #[Column(type: Types::STRING, length:60, nullable:true)]
    private string $lastname;
    #[Column(type: Types::STRING, length:100)]
=======
    #[Column(unique: true, length: 60)]
    private string $login;
    #[Column(type: Types::STRING, length: 60, nullable: true)]
    private string $firstname;
    #[Column(type: Types::STRING, length: 60, nullable: true)]
    private string $lastname;
    #[Column(unique: true, type: Types::STRING, length: 125)]
>>>>>>> ce892771683db92c70b3a9836030ec5ba39b6c03
    private string $mail;
    #[OneToMany(mappedBy: 'user', targetEntity: Comment::class)]
    private Collection $comment;
<<<<<<< HEAD
    #[Column(type: Types::STRING ,nullable:true)]
    private string $role;
    #[OneToMany(mappedBy:'user',targetEntity: Post::class)]
=======
    #[Column(type: Types::STRING, length: 10)]
    private string $role;
    #[OneToMany(mappedBy: 'user', targetEntity: Post::class)]
>>>>>>> ce892771683db92c70b3a9836030ec5ba39b6c03
    private Collection $post;

    public function __construct(RegisterDTO $registerDTO)
    {
        $this->setLogin($registerDTO->login);
        $this->setMail($registerDTO->mail);
        $this->setPassword($registerDTO->password);
        $this->setRole($registerDTO->role);
        $this->setFirstname($registerDTO->firstName);
        $this->setLastname($registerDTO->lastName);

    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword(string $password):User
    {
        $this->password = password_hash($password, \PASSWORD_DEFAULT);

        return $this;
    }
    public function getLogin()
    {
        return $this->login;
    }
    public function setLogin(string $login):User
    {
        if (\strchr($login, " ")) {
            throw new \InvalidArgumentException("your login cannot contain spaces");
        }
        $this->login = $login;

        return $this;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname):User
    {
        if (null !== $firstname) {
            $this->firstname = $firstname;
        }

        return $this;
    }
    public function getLastname()
    {
        return $this->lastname;
    }
    public function setLastname(string $lastname):User
    {
        if (null !== $lastname) {
            $this->lastname = $lastname;
        }

        return $this;
    }
    public function getMail()
    {
        return $this->mail;
    }
    public function setMail(string $mail):User
    {
        if (!\filter_var($mail, \FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('email is not a valid email!');
        }
        $this->mail = $mail;

        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getRole(): RoleEnum
    {
        return RoleEnum::tryfrom($this->role) ?: throw new \Exception("your role is not configured");
    }
    public function setRole(RoleEnum $role):User
    {
        $this->role = $role->value;

        return $this;
    }
}
