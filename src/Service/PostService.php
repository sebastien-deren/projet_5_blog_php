<?php

namespace Blog\Service;

use Blog\DTO\Entitie\Comment\CommentDTO;
use Blog\Entity\Post;

use Blog\Service\CommentService;
use Blog\DTO\Entitie\Post\PostDTO;
use Blog\Service\Interface\Getter;
use Blog\DTO\Form\Post\PostCreationDTO;
use Doctrine\ORM\EntityManagerInterface;
use Blog\DTO\Entitie\Post\CompletePostDTO;
use Blog\DTO\Entitie\Post\PostModerationDTO;


class PostService implements Getter
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    public function CreatePost(PostCreationDTO $postToCreate): int
    {
        $userId = empty($_SESSION['id']) ? 1 : $_SESSION['id'];
        $user = $this->entityManager->find('\Blog\Entity\User', $userId);

        $post = new Post($user, $postToCreate->content, $postToCreate->title, $postToCreate->excerpt);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $post->getId();
    }
    /**
     * @return array<PostDTO>
     */
    public function getAll(): array
    {
        $postRepository = $this->entityManager->getRepository(Post::class);
        $posts = $postRepository->findAll();
        return $this->createPostListDTO($posts);
    }
    //this method will be rework in another feature
    public function getBy(array $param): PostDTO|array
    {
        $postrepository = $this->entityManager->getRepository(Post::class);
        $post = $postrepository->find($param);
        if ($post instanceof Post) {
            $comments = CommentService::getInCollection($post->getCommentByStatus("valid"));
            return new CompletePostDTo($post,$comments);
        } else {
            return $this->createPostListDTO($post);
        }
    }
    private function createPostListDTO(array $posts): array
    {
        $postCreation = fn($post)=> new PostDto($post);
        return array_map($postCreation(...),$posts);
    }
    /**
     * @return array<PostModerationDTO>
     */
    public function getPostsCommentsPending(): array
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();
        return \array_map($this->getCommentToModerate(...), $posts);
    }
    private function getCommentToModerate($post): ?PostModerationDTO
    {
        $getComment=fn($comment)=> new CommentDTO($comment); 
        $commentList = $post->getCommentPending()->toArray();
        $commentsToModerate = \array_map($getComment, $commentList);
        if (empty($commentsToModerate)) {
            return null;
        }
        return new PostModerationDTO($post, $commentsToModerate);

    }
    
}
