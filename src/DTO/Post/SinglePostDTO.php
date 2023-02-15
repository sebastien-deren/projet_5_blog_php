<?php
namespace Blog\DTO\Post;

use Blog\Entity\Post;

class SinglePostDTO extends PostDTO{

    public string $content;
    public function __construct(Post $post,public array $comments)
    {    
        $this->content = $post->getContent();
        parent::__construct($post);
    }

    /**
     * @var array<CommentDTO>
     *  */ 


}