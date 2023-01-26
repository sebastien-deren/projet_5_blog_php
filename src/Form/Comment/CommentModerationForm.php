<?php
declare(strict_types=1);

namespace Blog\Form\Comment;

use Blog\DTO\CommentModerationDTO;
use Blog\DTO\CommentModerationListDTO;
use Blog\Enum\CommentStatus;
use Exception;
use Symfony\Component\Console\Exception\MissingInputException;

class CommentModerationForm
{
    public function __construct(private CommentModerationListDTO $commentList)
    {
        
    }
    public function validify($data): CommentModerationListDTO
    {
        isset($data) ?: throw new MissingInputException("veuillez selectionner au moins un commentaire a modérer");
        $this->createCommentListDTO($data);
        return $this->commentList;
    }
    private function createCommentListDTO(array $idComments)
    {
        foreach ($idComments as $idComment) {
            $CommentDTO = new CommentModerationDTO(\intval($idComment));
            $this->commentList->addcomment($CommentDTO);
        }
    }
}
