<?php

declare(strict_types=1);

namespace Blog\Service;

use Blog\Entity\Comment;
use Blog\Enum\CommentStatus;
use Blog\DTO\Comment\CommentDTO;
use Blog\DTO\Comment\CommentModerationListDTO;


class CommentService extends Service
{

    public function moderateComments(CommentModerationListDTO $commentList): array
    {
        $commentRepo = $this->entityManager->getRepository(Comment::class);
        foreach ($commentList->commentsToModerate as $comment) {
            $commentEntity = $commentRepo->find($comment->id);
            $commentEntity->getValidity() === CommentStatus::Pending ?: throw new \InvalidArgumentException("le commentaire à déjà été modéré");
            $commentEntity->setValidity($commentList->validity);
        }
        $this->entityManager->flush();
        return ["number"=>count($commentList->commentsToModerate),"method"=> $commentList->validity->value];
    }
    public function getCommentToModerate(): array
    {
        $commentRepo = $this->entityManager->getRepository(Comment::class);

        $commentUnModeratedArray = $commentRepo->findBy(["validity" => CommentStatus::Pending->value], ["date" => "DESC"],);
        if (empty($commentUnModeratedArray)) {
            throw new \InvalidArgumentException("no comment to moderate");
        }
        $commentList= [];
        foreach ($commentUnModeratedArray as $commentUnModerated) {
            $commentList[] = $this->createCommentDTO($commentUnModerated);
        }
        return $commentList;
    }
    public static function createCommentDTO(Comment $comment): CommentDTO
    {
        $commentDTO = new CommentDTO;
        $commentDTO->content = $comment->getContent();
        $commentDTO->authorName = $comment->getUser()->getFirstname() . " " . $comment->getUser()->getLastname();
        $commentDTO->date = \date_format($comment->getDate(), "Y-m-d H:i:s");
        $commentDTO->id = $comment->getId();
        return $commentDTO;
    }
    public static function getCommentsByValidity($collectionComment, CommentStatus $status): ?array
    {
        if (empty($collectionComment)) {
            return null;
        }
        $comments =[];
        foreach ($collectionComment as $comment) {
            if ($comment->getValidity() === $status) {

                $comments[] = CommentService::createCommentDTO($comment);
            }
        }
        return $comments;
    }
}
