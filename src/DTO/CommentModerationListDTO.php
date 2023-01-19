<?php
declare(strict_types=1);
namespace Blog\DTO;

use Blog\Enum\CommentStatus;

class CommentModerationListDTO{
    public array $commentsToModerate;
    public function __construct(public CommentStatus $validity)
    {}
    public function addcomment(CommentModerationDTO $comment){
        $this->commentsToModerate[] = $comment;
    }
}