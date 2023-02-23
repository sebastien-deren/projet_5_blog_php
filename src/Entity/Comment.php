<?php

declare(strict_types=1);

namespace Blog\Entity;

use Blog\Enum\CommentStatus;
use Doctrine\ORM\Mapping\Id;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\GeneratedValue;

#[Entity()]
class Comment
{
    #[Id]
    #[Column(type: Types::INTEGER, updatable: false, unique: true)]
    #[GeneratedValue()]
    private int $id;
    #[Column(type: Types::TEXT)]
    private  $content;
    #[Column()]
    private \DateTime $date;
    #[ManyToOne(targetEntity:User::class,inversedBy:'comment')]
    #[JoinColumn(referencedColumnName:'id',name:'user_id')]
    private User|null $user =null;
    #[ManyToOne(targetEntity:Post::class,inversedBy:'comment')]
    #[JoinColumn(name:'post_id',referencedColumnName:'id')]
    private Post|null $post =null;
    #[Column(type: Types::STRING, nullable: true)]
    private string $validity;

    public function __construct()
    {
    }
    public function getId()
    {
        return $this->id;
    }
    public function getContent()
    {
        return $this->content;
    }

    public function getDate()
    {
        return $this->date;
    }
    public function setDate()
    {
        $this->date = new \DateTime();
        return $this;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function setPost(Post $post)
    {
        $this->post= $post;
        return $this;
    }
    public function setUser(User $user)
    {
        $this->user =$user;
        return $this;
    }
    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }

    public function getPost()
    {
        return $this->post;
    }

    /**
     * Get the value of validity
     */ 
    public function getValidity()
    {
        if(!isset($this->validity)){
            return CommentStatus::Pending;
        }
        return CommentStatus::from($this->validity);
    }

    public function setValidity(CommentStatus $validity)
    {
        $this->validity = $validity->value;

        return $this;
    }
}
