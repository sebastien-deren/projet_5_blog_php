<?php
namespace Blog\DTO\Comment;

use Blog\DTO\AbstractDTO;

class CreateComment extends AbstractDTO
{
    public string $content;
    public int $postId;
}