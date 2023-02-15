<?php
namespace Blog\DTO\Post;

class SinglePostDTO extends PostDTO{

    /**
     * @var array<CommentDTO>
     *  */ 
    public array $comments;
    public string $content;

}