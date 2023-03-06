<?php

namespace Blog\DTO\Entity\Post;

use Blog\Entity\Post;

class PostModerationDTO
{
    public array $comments;
    public string $author;
    public string $title;
    public string $date;
    public function __construct(Post $post, array $comments)
    {
        $this->author = $post->getUser()->getFullName();
        $this->title = $post->getTitle();
        $this->date = \date_format($post->getDate(), "Y-m-d h:i:s");
        $this->comments = $comments;
    }
}
