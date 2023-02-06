<?php
namespace Blog\Service;

use Exception;
use Blog\Entity\Post;
use Blog\Entity\User;
use Blog\Entity\Comment;
use Blog\DTO\AbstractDTO;
use Blog\DTO\Comment\CommentDTO;
use Blog\Service\Interface\Getter;
use Blog\DTO\Comment\CreateComment;
use Blog\Service\Interface\Creater;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;

class CommentService implements Getter, Creater{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    public function getAll(){

    }
    public function getBy(array $param)
    {
        
    }
    public function create(AbstractDTO $objecttoCreate)  
    {
        if(!($objecttoCreate instanceof CreateComment)){
            throw new Exception("nope");
        }
        /*if(!isset($_SESSION['id'])){
            throw new Exception("you must be connected to write a comment");
        }*/
        $user =$this->entityManager->find(User::class,$_SESSION['id']??11);
        $blogPost= $this->entityManager->find(Post::class,$objecttoCreate->postId);
        if(!$user || !$blogPost){
            throw new Exception("invalid user or post Id");
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

        $arrayCommentsDTO = [];
        foreach ($comments as $comment) {
            $arrayCommentsDTO[] =self::createDTO($comment);
        }
        return $arrayCommentsDTO;
        
    }
    
    private static function createDTO(Comment $comment){
        $commentDTO = new CommentDTO;
        $commentDTO->content = $comment->getContent();
        $commentDTO->author = $comment->getUser()->getFullName();
        $commentDTO->date = $comment->getDate()->format("Y-m-d H:i:s");
        return $commentDTO;
    }
}