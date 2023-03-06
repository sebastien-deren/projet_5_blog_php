<?php

declare(strict_types=1);

namespace Blog\DTO\Form\Comment;

use Blog\DTO\AbstractDTO;
use Blog\Enum\CommentStatus;

class CommentModerationListDTO
{
    /**
     * @var array<int(commentid)>
     */
    public array $commentsToModerate;
    public CommentStatus $validity;
}
