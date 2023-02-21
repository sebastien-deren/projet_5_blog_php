<?php

namespace Blog\DTO\Entitie\Post;

use Blog\Entity\Post;
//not to be confused with single Post DTO who will display a lot more
class PostDTO
{
    public string $title;
    public int $id;
    public string $excerpt;
    public string $author;
    public string $date;
    public function __construct(Post $post)
    {
        $this->id = $post->getId();
        $this->title = $post->getTitle();
        $this->excerpt = $post->getExcerpt();
        $this->author = $post->getUser()->getFullName();
        $this->date = $post->getDate()->format("Y-m-d H:i:s");
    }
}
