<?php

namespace Blog\DTO\Entitie\Post;

use Blog\Entity\Post;
use Blog\Service\CommentService;

class CompletePostDTO extends PostDTO
{

    /**
     * @var array<CommentDTO>
     *  */
    public array $comments;
    public string $content;


    public function __construct(Post $post,$comments)
    {
        parent::__construct($post);
        $this->content = $post->getContent();
        $this->comments = $comments;
    }
}
