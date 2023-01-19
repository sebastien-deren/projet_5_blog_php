<?php
declare(strict_types=1);
namespace Blog\Service;

use Exception;
use Blog\DTO\CommentDTO;
use Blog\Entity\Comment;
use Doctrine\ORM\NoResultException;
use Blog\DTO\CommentModerationListDTO;
use Blog\Enum\CommentStatus;
use Doctrine\Common\Cache\Psr6\InvalidArgument;
use Doctrine\Instantiator\Exception\UnexpectedValueException;
use InvalidArgumentException;

class CommentService extends Service
{

    public function moderateComments(CommentModerationListDTO $commentList):int
    {
        $commentRepo = $this->entityManager->getRepository(Comment::class);
        foreach ($commentList->commentsToModerate as $comment) {
            $commentEntity = $commentRepo->find($comment->id);
            $commentEntity->getValidity()===CommentStatus::Pending?:throw new InvalidArgumentException("le commentaire à déjà été modéré");
            $commentEntity->setValidity($commentList->validity);
        }
        $this->entityManager->flush();
        return count($commentList->commentsToModerate);
    }
    public function getCommentNotModerate(): array
    {
        $commentRepo = $this->entityManager->getRepository(Comment::class);

        $commentUnModeratedArray = $commentRepo->findBy(["validity" => CommentStatus::Pending->value], ["date" => "DESC"],);
        if (empty($commentUnModeratedArray)) {
            throw new InvalidArgumentException("no comment to moderate");
        }
        foreach ($commentUnModeratedArray as $commentUnModerated) {
            $commentList[] = $this->createCommentDTO($commentUnModerated);
        }
        return $commentList;
    }
    public function createCommentDTO(Comment $comment):CommentDTO
    {
        $commentDTO = new CommentDTO;
        $commentDTO->content = $comment->getContent();
        $commentDTO->authorName = $comment->getUser()->getFirstname() . " " . $comment->getUser()->getLastname();
        $commentDTO->date = \date_format($comment->getDate(), "Y-m-d H:i:s");
        $commentDTO->id = $comment->getId();
        return $commentDTO;
    }
}
