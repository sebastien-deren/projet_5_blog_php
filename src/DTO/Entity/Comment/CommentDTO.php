<?php

declare(strict_types=1);

namespace Blog\DTO\Entity\Comment;

use Blog\Controller\Traits\Token;
use Blog\Entity\Comment;

class CommentDTO
{
    public string $content;
    public string $author;
    public string $date;
    public int $id;
    public function __construct(Comment $comment)
    {
        $this->content = $comment->getContent();
        $this->author = $comment->getUser()->getFirstname() . " " . $comment->getUser()->getLastname();
        $this->date = \date_format($comment->getDate(), "Y-m-d H:i:s");
        $this->id = $comment->getId();
    }
}
