<?php

declare(strict_types=1);

namespace Blog\Entity;

use DateTime;
use Blog\Enum\CommentStatus;
use Doctrine\ORM\Mapping\Id;
use Doctrine\DBAL\Types\Types;
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
class Post
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
    private User $user;
    #[OneToMany(mappedBy: 'post', targetEntity: Comment::class, cascade: ['remove'])]
    private Collection $comment;

    public function __construct(User $user, string $content, string $title, string $excerpt)
    {
        $this->user = $user;
        $this->content = $content;
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = new \DateTime();
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getContent(): string
    {
        return $this->content;
    }
    public function getDate(): \DateTime
    {
        return $this->date;
    }
    public function getUser(): User
    {
        return $this->user;
    }
    public function getExcerpt(): string
    {
        return $this->excerpt;
    }
    public function getComment(): Collection
    {
        return $this->comment;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getCommentApproved(): Collection
    {
        return $this->getCommentByStatus(CommentStatus::Approved);
    }
    public function getCommentPending(): Collection
    {
        return $this->getCommentByStatus(CommentStatus::Pending);
    }
    private function getCommentByStatus(CommentStatus $status): Collection
    {
        /*Doctrine use the Status getter to make the comparison 
        since our getStatus return an Enum we must compare Enum and not string!
        */
        $criteria = new Criteria();
        $expr = new Comparison("validity", Comparison::IS, $status);
        $criteria->where($expr);
        $criteria->orderBy(['date' => 'DESC']);
        return (new arrayCollection($this->comment->toArray()))->matching($criteria);
    }


    public function setExcerpt(string $excerpt): Post
    {
        $this->excerpt = $excerpt;

        return $this;
    }


    public function setContent(string $content): Post
    {
        $this->content = $content;

        return $this;
    }

    public function setDate(\DateTime $date): Post
    {
        $this->date = $date;

        return $this;
    }


    public function setUser(User $user): Post
    {
        if ($user === null) {
            return $this;
        }
        $this->user = $user;

        return $this;
    }

    public function setTitle(string $title): Post
    {
        $this->title = $title;

        return $this;
    }
}
