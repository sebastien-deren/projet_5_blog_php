<?php
namespace Blog\DTO\Post;
//not to be confused with single Post DTO who will display a lot more
class PostDTO{
    public string $title;
    public int $id;
    public string $excerpt;
    public string $author;
    public string $date;
}