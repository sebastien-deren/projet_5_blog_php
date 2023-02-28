<?php

declare(strict_types=1);

namespace Blog\Service;

use Blog\Entity\Post;
use Blog\Entity\User;
use Blog\Service\Interface\Getter;
use Blog\DTO\Comment\CreateComment;
use Blog\Service\Interface\Creater;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
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
    private ObjectRepository|EntityRepository $repoComment;
    private function __construct(private EntityManager $entityManager)
    {
        $this->repoComment = $this->entityManager->getRepository(Comment::class);
    }
    /**
     * getService
     * @param EntityManager $entityManager
     * @return CommentService
     */
    public static function getService($entityManager) : CommentService
    {
        if (is_null(self::$_CommentService)) {
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

    public function create(CreateComment $objecttoCreate,int $userId)  
    {
        $user =UserService::getService($this->entityManager)->getUser($userId);
        $blogPost= $this->entityManager->find(Post::class, $objecttoCreate->postId);
        if(!$user || !$blogPost) {
            throw new \Exception("invalid user or post Id");
        }
        
        $comment = new Comment;
        $comment->setDate();
        $comment->setContent($objecttoCreate->content);
        $comment->setUser($user);
        $comment->setPost($blogPost);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
    /**
     * @return CommentDTO
     */
    public static function createDTO(Comment $comment):CommentDTO
    {
        $commentDTO = new CommentDTO;
        $commentDTO->content = $comment->getContent();
        $commentDTO->author = $comment->getUser()->getFullName();
        $commentDTO->date = $comment->getDate()->format("Y-m-d H:i:s");
        $commentDTO->id = $comment->getId();
        return $commentDTO;
    }
}
