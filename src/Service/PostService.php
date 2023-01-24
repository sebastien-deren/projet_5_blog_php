<?php

namespace Blog\Service;

use Blog\Entity\Post;
use Blog\Entity\Comment;
use Blog\DTO\Post\PostDTO;
use Blog\DTO\Post\ListPostDTO;
use Blog\DTO\Comment\CommentDTO;
use Blog\DTO\Post\createPostDTO;
use Blog\DTO\Post\SinglePostDTO;
use Blog\Service\Interface\Getter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;

class PostService implements Getter
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        
    }
    public function CreatePost(CreatePostDTO $postToCreate): int
    {
        //to work again with new UserService
        $userId = empty($_SESSION['id']) ? 1 : $_SESSION['id'];
        $user = $this->entityManager->find('\Blog\Entity\User', $userId);
        /*here do we want a DTO? I think we need a entity/User.
        If we send it only to our entity post I think it's ok to send an User entity 
        */

        $post = new Post($user, $postToCreate->content, $postToCreate->title, $postToCreate->excerpt);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $post->getId();
    }
    public function getAll():ListPostDTO{
        $postRepository = $this->entityManager->getRepository(Post::class);
        $posts = $postRepository->findAll();
        $postList = new ListPostDTO;
        foreach($posts as $post){

            $postList->listPost[] = $this->createPostDTO($post,new PostDTO);
        }
        return $postList;
    }
    public function getByID(int $id)
    {
        $postrepository =$this->entityManager->getRepository(Post::class);
        $post = $postrepository->find($id);
        return $this->createSinglePostDTO($post);


    }
    private function createPostDTO(Post $post,PostDTO|SinglePostDTO $postDTO):PostDTO|SinglePostDTO{
        $postDTO->id = $post->getId();
        $postDTO->title = $post->getTitle();
        $postDTO->excerpt =$post->getExcerpt();
        $postDTO->author =$post->getUser()->getFullName();
        $postDTO->date = $post->getDate()->format("Y-m-d H:i:s");
        return $postDTO;
    }
    private function createSinglePostDTO(Post $post):SinglePostDTO{
        $singlePostDTO=new SinglePostDTO;
        $this->createPostDTO($post,$singlePostDTO);
        $singlePostDTO->content = $post->getContent();
        $singlePostDTO->comments = $this->createCommentDTO($post->getComment());
        return $singlePostDTO;
    }
    private function createCommentDTO(Collection $comments):array{
        $arrayCommentsDTO =[];
        /*this do NOT belong here we will move it to a commentSERVICE 
        And we will refactor it, to make the method single responsability*/
        foreach($comments as $comment){
            /* We'll have to get the comment filtered by validity
                this is done in another feature we will need to wait for this feature to be accepted to do that.
            */
            $commentDTO =new CommentDTO;
            $commentDTO->content =$comment->getContent();
            $commentDTO->author=$comment->getUser()->getFullName();
            $commentDTO->date = $comment->getDate()->format("Y-m-d H:i:s");
            $arrayCommentsDTO[]=$commentDTO;
        }
        return $arrayCommentsDTO;
    }

}
