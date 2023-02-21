<?php

declare(strict_types=1);

namespace Blog\Service;

use Blog\Entity\Post;
use Blog\Entity\User;
use Blog\Entity\Comment;
use Blog\Enum\CommentStatus;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Blog\DTO\Entitie\Comment\CommentDTO;
use Doctrine\Persistence\ObjectRepository;
use Blog\DTO\Form\Comment\CommentCreationDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Blog\DTO\Form\Comment\CommentModerationListDTO;


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
            $commentEntity = $commentRepo->find($comment)?: throw new \Exception("le commentaire n'existe pas");
            $commentEntity->getValidity() === CommentStatus::Pending ?: throw new \InvalidArgumentException("le commentaire à déjà été modéré");
            $commentEntity->setValidity($commentList->validity);
        }
        $this->entityManager->flush();
        return ["number"=>count($commentList->commentsToModerate),"method"=> $commentList->validity->value];
    }
    public function create(CommentCreationDTO $objecttoCreate, int $userId)  
    {
        $commentDTO = new CommentDTO;

    
        $user =$this->entityManager->find(User::class,$_SESSION['id']??11);
        $blogPost= $this->entityManager->find(Post::class,$objecttoCreate->postId);
        if(!$user || !$blogPost){
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
    public static function getInCollection(ArrayCollection $comments){

        $creationDTO = fn($comment)=> new CommentDTO($comment);
        return \array_map($creationDTO(...),$comments->toArray());
    }
}
