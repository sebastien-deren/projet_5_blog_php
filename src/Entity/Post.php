<?php

declare(strict_types=1);

namespace Blog\Entity;

use DateTime;
use Blog\Enum\CommentStatus;
use Doctrine\ORM\Mapping\Id;
use Doctrine\DBAL\Types\Types;
use Blog\Entity\ContentAbstract;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Expr\Comparison;

#[Entity()]
class Post extends ContentAbstract
{
    #[Id]
    #[Column(unique: true, updatable: false)]
    #[GeneratedValue()]
    private int $id;
    #[Column(length: 255)]
    private string $excerpt;
    #[Column()]
    private string $title;
    #[Column(type: Types::TEXT)]
    private string $content;
    #[Column(type: TYPES::DATETIME_MUTABLE)]
    private \DateTime $date;
    #[ManyToOne(targetEntity: User::class, inversedBy: 'post')]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User|null  $user = null;
    #[OneToMany(mappedBy: 'post', targetEntity: Comment::class)]
    private Collection $comment;

    public function __construct($user)
    {
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
    public function getDate()
    {
        return $this->date;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function getExcerpt()
    {
        return $this->excerpt;
    }
    public function getComment()
    {
        return $this->comment;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function addpost($field)
    {
        $this->content = $field['content'];
        $this->title = $field['title'];
        $this->excerpt = $field['exerpt'];
        $this->date = new \DateTime();
    }
    public function getCommentPending()
    { 
        $criteria = new Criteria();
        /*Doctrine use the Status getter to make the comparison 
        since our getStatus return an Enum we must compare Enum and not string!
        */
        $expr = new Comparison("validity",Comparison::IS, CommentStatus::Pending);
        $criteria->where($expr);
        $criteria->orderBy(['date' => 'DESC']);
        return (new arrayCollection($this->comment->toArray()))->matching($criteria);
    }
}
