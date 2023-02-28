<?php

declare(strict_types=1);

namespace Blog\DTO\Comment;


class CommentModerationDTO
{
    public function __construct(public int $id)
    {
    }
}
