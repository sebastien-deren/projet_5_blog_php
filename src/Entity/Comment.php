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
    #[ManyToOne(targetEntity: User::class, inversedBy: 'comment')]
    #[JoinColumn(referencedColumnName: 'id', name: 'user_id')]
    private User|null $user = null;
    #[ManyToOne(targetEntity: Post::class, inversedBy: 'comment')]
    #[JoinColumn(name: 'post_id', referencedColumnName: 'id')]
    private Post|null $post = null;
    #[Column(type: Types::STRING, nullable: true)]
    private string $validity;

    public function __construct()
    {
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
    public function setDate(): Comment
    {
        $this->date = new \DateTime();
        return $this;
    }
    public function getUser(): User
    {
        return $this->user;
    }
    public function setPost(Post $post): Comment
    {
        $this->post = $post;
        return $this;
    }
    public function setUser(User $user): Comment
    {
        $this->user = $user;
        return $this;
    }
    public function setContent(string $content): Comment
    {
        $this->content = $content;
        return $this;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getValidity(): CommentStatus
    {
        if (!isset($this->validity)) {
            return CommentStatus::Pending;
        }
        return CommentStatus::from($this->validity);
    }

    public function setValidity(CommentStatus $validity): Comment
    {
        $this->validity = $validity->value;

        return $this;
    }
}
