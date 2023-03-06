<?php

namespace Blog\DTO\Entity\Post;

use Blog\Entity\Post;
use Blog\Service\CommentService;
use Blog\DTO\Entity\Post\PostDTO;

class CompletePostDTO extends PostDTO
{

    /**
     * @var array<CommentDTO>
     *  */
    public array $comments;
    public string $content;


    public function __construct(Post $post,array $comments)
    {
        parent::__construct($post);
        $this->content = $post->getContent();
        $this->comments = $comments;
    }
}
