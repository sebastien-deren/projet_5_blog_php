<?php
namespace Blog\DTO\Post;

use Blog\Entity\Post;

class SinglePostDTO extends PostDTO{

    public string $content;
    public int $authorId;
    public function __construct(Post $post,public array $comments)
    {    
        $this->content = $post->getContent();
        $this->authorId = $post->getUser()->getId();
        parent::__construct($post);
    }

    /**
     * @var array<CommentDTO>
     *  */ 


}