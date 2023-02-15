<?php
namespace Blog\DTO\Comment;

use Blog\DTO\AbstractDTO;

class CommentDTO extends AbstractDTO{
    public string $content;
    public string $author;
    public string $date;
}