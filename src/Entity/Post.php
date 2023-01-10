<?php
namespace Blog\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity()]
class Post extends ContentAbstract{
    #[Column(unique:true,updatable:false)]
    #[GeneratedValue()]
    private int $id;
    #[Column()]
    private string $excerpt;
    #[Column()]
    private string $content;
    #[Column(type: TYPES::DATETIME_MUTABLE)]
    private \DateTime $date;
    #[ManyToOne(targetEntity:User::class,inversedBy:'post')]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User|null  $user=null;
    #[OneToMany(mappedBy:'post',targetEntity:Comment::class)]
    private Collection $comment;

    public function __construct($user){
        $this->user = $user;

    }
    public function getId()
    {
        return $this->id;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function setDate()
    {
        $this->date= new \DateTime();
        return $this;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
    public function getExcerpt()
    {
        return $this->excerpt;
    }
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }
    public function getComment()
    {
        return $this->comment;
    }
}