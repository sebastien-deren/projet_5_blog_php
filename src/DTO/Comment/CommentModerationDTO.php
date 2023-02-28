<?php
declare(strict_types=1);
namespace Blog\DTO\Comment;


class CommentModerationDTO
{
    /**
     * @param int $id the id of a comment
     *
     * @return void
     */


    public function __construct(public int $id)
    {
    }


}