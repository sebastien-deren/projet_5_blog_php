<?php
declare(strict_types=1);

namespace Blog\Form\Comment;

use Blog\DTO\CommentModerationDTO;
use Blog\DTO\CommentModerationListDTO;
use Blog\Enum\CommentStatus;
use Exception;
use Symfony\Component\Console\Exception\MissingInputException;

class CommentModerationValidify
{
    private CommentModerationListDTO $commentList;
    public function arrayToObjectCommentList($data): CommentModerationListDTO
    {
        $isValidComment = CommentStatus::from($data['input']) ;
        $this->commentList = new CommentModerationListDTO($isValidComment);
        \array_key_exists('id', $data) ?: throw new MissingInputException("veuillez selectionner au moins un commentaire a modérer");
        $this->putObjectCommentInArray($data['id'], $isValidComment);
        return $this->commentList;
    }
    private function putObjectCommentInArray(array $idComments, CommentStatus $valid)
    {
        foreach ($idComments as $idComment) {
            $CommentDTO = new CommentModerationDTO($idComment,$valid);
            $this->commentList->addcomment($CommentDTO);
        }
    }
}
