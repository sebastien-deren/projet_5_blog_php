<?php
declare(strict_types=1);
namespace Blog\DTO\Comment;

class CommentDTO
{
    public string $content;
    public string $author;
    public string $date;
    public int $id;
}