<?php

namespace Blog\Service;

use Exception;
use Blog\DTO\CommentDTO;
use Blog\Entity\Comment;
use Doctrine\ORM\NoResultException;
use Blog\DTO\CommentModerationListDTO;
use Blog\Enum\CommentStatus;
use Doctrine\Instantiator\Exception\UnexpectedValueException;

class CommentService extends Service
{

    public function moderateComments(CommentModerationListDTO $commentList)
    {
        $commentRepo = $this->entityManager->getRepository(Comment::class);
        foreach ($commentList->commentsToModerate as $comment) {
            $commentEntity = $commentRepo->find($comment->id);
            $commentList->validity == CommentStatus::Deleted ? $this->entityManager->remove($commentEntity) : $commentEntity->setValidity($commentList->validity);
        }
        $this->entityManager->flush();
        return count($commentList->commentsToModerate);
    }
    public function getCommentNotModerate(): array
    {
        $commentRepo = $this->entityManager->getRepository(Comment::class);

        $commentUnModeratedArray = $commentRepo->findBy(["validity" => CommentStatus::Pending->value], ["date" => "DESC"],);
        if (empty($commentUnModeratedArray)) {
            throw new UnexpectedValueException("no comment to moderate");
        }
        foreach ($commentUnModeratedArray as $commentUnModerated) {
            $commentList[] = $this->createCommentDTO($commentUnModerated);
        }
        return $commentList;
    }
    public function createCommentDTO(Comment $comment)
    {
        $commentDTO = new CommentDTO;
        $commentDTO->content = $comment->getContent();
        $commentDTO->authorName = $comment->getUser()->getFirstname() . " " . $comment->getUser()->getLastname();
        $commentDTO->date = \date_format($comment->getDate(), "Y-m-d H:i:s");
        $commentDTO->id = $comment->getId();
        return $commentDTO;
    }
}
