<?php
declare(strict_types=1);
namespace Blog\DTO;

use Blog\Enum\CommentStatus;

class CommentModerationDTO{
    public function __construct(public int $id){}
}