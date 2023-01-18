<?php

declare(strict_types=1);

namespace Blog\Entity;

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
    #[Column(unique: true, length: 60)]
    private string $login;
    #[Column(type: Types::STRING, length: 30,nullable: true)]
    private string $firstname;
    #[Column(type: Types::STRING, length: 30, nullable:true)]
    private string $lastname;
    #[Column(type: Types::STRING, length: 40)]
    private string $mail;
    #[OneToMany(mappedBy: 'user', targetEntity: Comment::class)]
    private Collection $comment;
    #[Column(type: Types::STRING,length:10, nullable:true)]
    private string $role;
    #[OneToMany(mappedBy: 'user', targetEntity: Post::class)]
    private Collection $post;

    public function __construct(string $login, string $password, string $mail,RoleEnum $role)
    {
        if (!\filter_var($mail, \FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('email is not a valid email!');
        }
        $this->mail = $mail;
        if (\strchr($login, " ")) {
            throw new \InvalidArgumentException("your login cannot contain spaces");
        }
        $this->login = $login;
        $this->password = password_hash($password, \PASSWORD_DEFAULT);
        $this->role = $role->value;
    }
    public function updateUser(string $firstname, string $lastname)
    {
        if ($firstname !== \null) {
            $this->firstname = $firstname;
        }
        if ($lastname !== \null) {
            $this->lastname = $lastname;
        }
        }
    public function checkPassword($password)
    {
        return \password_verify($password,$this->password);
    }
    public function setPassword($password)
    {
        $this->password = password_hash($password, \PASSWORD_DEFAULT);

        return $this;
    }
    public function getLogin()
    {
        return $this->login;
    }
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }
    public function getLastname()
    {
        return $this->lastname;
    }
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }
    public function getMail()
    {
        return $this->mail;
    }
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getRole():RoleEnum
    {
      return RoleEnum::tryfrom($this->role)?:throw new \Exception("your role is not configured what did you do you fool!");
    }
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}
