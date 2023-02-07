<?php
namespace Blog\DTO\Post;

use Blog\Entity\User;
use Blog\DTO\AbstractDTO;

class createPostDTO extends AbstractDTO{
    public string $title;
    public string $excerpt;
    public string $content;
    public User $user;
}