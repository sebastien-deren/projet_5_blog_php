<?php
namespace Blog\DTO\Post;
class PostDisplayDTO{
    public string $author;
    public string $title;
    public string $date;
    public array $comments;
    public int $authorId;
    
}