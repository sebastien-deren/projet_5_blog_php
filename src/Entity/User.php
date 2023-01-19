<?php
declare(strict_types=1);
namespace Blog\Entity;

use Doctrine\ORM\Mapping\Id;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;


//anemic class with setter & getter for all attribute except id (only getter)
#[Entity]
class User{
    #[Id]
    #[Column(type: TYPES::INTEGER, updatable: false, unique: true)]
    #[GeneratedValue()]
    private int $id;
    #[Column()]
    private string $password;
    #[Column(unique:true, length:255)]
    private string $login;
    #[Column(type: Types::STRING, length:255, nullable:true)]
    private string $firstname;
    #[Column(type: Types::STRING, length:60, nullable:true)]
    private string $lastname;
    #[Column(type: Types::STRING, length:100)]
    private string $mail;
    #[OneToMany(mappedBy:'user',targetEntity: Comment::class)]
    private Collection $comment;
    #[Column(type: Types::STRING ,nullable:true)]
    private int $role;
    #[OneToMany(mappedBy:'user',targetEntity: Post::class)]
    private Collection $post;
    
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;

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
    public function getRole()
    {
        return $this->role;
    }
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}