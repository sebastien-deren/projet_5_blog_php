<?php
namespace Blog\DTO;

use Blog\Enum\CommentStatus;

class CommentModerationDTO{
    public function __construct(public int $id,public CommentStatus $validate){}
}