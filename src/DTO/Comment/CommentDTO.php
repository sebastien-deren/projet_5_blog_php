<?php
declare(strict_types=1);
namespace Blog\DTO\Comment;

class CommentDTO{
    public string $content;
    public string $authorName;
    public string $date;
    public int $id;
}