<?php
namespace Blog\DTO\Post;
class UpdatePostDTO{
    public string $title;
    public string $content;
    public int $authorId;
    public string $excerpt;
    public int $id;
}
