<?php
declare(strict_types=1);
namespace Blog\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity()]
class Comment{
    #[Id]
    #[Column(type: Types::INTEGER, updatable:false,unique:true)]
    #[GeneratedValue()]
    private int $id;
    #[Column()]
    private  $content;
    #[Column()]
    private \DateTime $date;
    #[ManyToOne(targetEntity:User::class,inversedBy:'comment')]
    #[JoinColumn(referencedColumnName:'id',name:'user_id')]
    private User|null $user =null;
    #[ManyToOne(targetEntity:Post::class,inversedBy:'comment')]
    #[JoinColumn(name:'post_id',referencedColumnName:'id')]
    private Post|null $post =null;

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
    public function getPost()
    {
        return $this->post;
    }
}