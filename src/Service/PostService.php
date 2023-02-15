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
        $userId = empty($_SESSION['id']) ? 1 : $_SESSION['id'];
        $user = $this->entityManager->find('\Blog\Entity\User', $userId);

        $post = new Post($user, $postToCreate->content, $postToCreate->title, $postToCreate->excerpt);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $post->getId();
    }
    public function getAll(): ListPostDTO
    {
        $postRepository = $this->entityManager->getRepository(Post::class);
        $posts = $postRepository->findAll();
        return $this->createPostListDTO($posts);
    }
    public function getBy(array $param): PostDTO|ListPostDTO
    {
        $postrepository = $this->entityManager->getRepository(Post::class);
        $post = $postrepository->find($param);
        if ($post instanceof Post) {
            return $this->createSinglePostDTO($post);
        } else {
            return $this->createPostListDTO($post);
        }
    }
    private function createPostListDTO(array $posts): ListPostDTO
    {
        $postList = new ListPostDTO;
        foreach ($posts as $post) {

            $postList->listPost[] = $this->createPostDTO($post, new PostDTO);
        }
        return $postList;
    }
    private function createPostDTO(Post $post, PostDTO|SinglePostDTO $postDTO): PostDTO|SinglePostDTO
    {
        $postDTO->id = $post->getId();
        $postDTO->title = $post->getTitle();
        $postDTO->excerpt = $post->getExcerpt();
        $postDTO->author = $post->getUser()->getFullName();
        $postDTO->date = $post->getDate()->format("Y-m-d H:i:s");
        return $postDTO;
    }
    private function createSinglePostDTO(Post $post): SinglePostDTO
    {
        $singlePostDTO = new SinglePostDTO;
        $this->createPostDTO($post, $singlePostDTO);
        $singlePostDTO->content = $post->getContent();
        $singlePostDTO->comments = CommentService::getInCollection($post->getCommentByStatus("valid"));
        return $singlePostDTO;
    }
    
}
