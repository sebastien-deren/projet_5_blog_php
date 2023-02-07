<?php

declare(strict_types=1);

namespace Blog\Service;

use Blog\Entity\Comment;
use Blog\Enum\CommentStatus;
use Doctrine\ORM\EntityManager;
use Blog\DTO\Comment\CommentDTO;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Blog\DTO\Comment\CommentModerationListDTO;


class CommentService
{
    private static ?CommentService $_CommentService =null;
    private Comment $comment;
    private ObjectRepository|EntityRepository $repoComment;
    private function __construct(private EntityManager $entityManager)
    {
        $this->repoComment = $this->entityManager->getRepository(Comment::class);
    }

    public static function getService($entityManager){
        if (is_null(self::$_CommentService)){
            self::$_CommentService = new CommentService($entityManager);
        }
        return self::$_CommentService;
    }

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
    public function getCommentDTO(Comment $comment): CommentDTO
    {
        $commentDTO = new CommentDTO;

        $commentDTO->content = $comment->getContent();
        $commentDTO->authorName = $comment->getUser()->getFirstname() . " " . $comment->getUser()->getLastname();
        $commentDTO->date = \date_format($comment->getDate(), "Y-m-d H:i:s");
        $commentDTO->id = $comment->getId();
        return $commentDTO;
    }
}
