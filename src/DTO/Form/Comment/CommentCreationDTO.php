<?php
namespace Blog\DTO\Form\Comment;

use Blog\DTO\AbstractDTO;

class CommentCreationDTO{
    public string $content;
    public int $postId;
}