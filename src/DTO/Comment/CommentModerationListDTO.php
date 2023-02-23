<?php
declare(strict_types=1);
namespace Blog\DTO\Comment;

use Blog\DTO\AbstractDTO;
use Blog\Enum\CommentStatus;
use Blog\DTO\Comment\CommentModerationDTO;

class CommentModerationListDTO extends AbstractDTO{
    public array $commentsToModerate;
    public CommentStatus $validity;
}