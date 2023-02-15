<?php

namespace Blog\Service;

use Blog\Entity\Post;
use Blog\DTO\Post\PostDTO;
use Blog\DTO\Post\ListPostDTO;
use Blog\DTO\Post\createPostDTO;
use Blog\Service\Interface\Getter;
use Doctrine\ORM\EntityManagerInterface;

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
            $postDTO = new PostDTO;
            $postDTO->id = $post->getId();
            $postDTO->title = $post->getTitle();
            $postDTO->excerpt =$post->getExcerpt();
            $postDTO->author =$post->getUser()->getFullName();
            $postDTO->date = $post->getDate()->format("Y-m-d H:i:s");
            $postList->listPost[] = $postDTO;
        }
        return $postList;
    }
    public function getByID()
    {
        
    }
}
