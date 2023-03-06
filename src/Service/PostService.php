<?php

namespace Blog\Service;

use Blog\Enum\CommentStatus;
use Blog\Service\CommentService;
use Blog\DTO\Post\PostDisplayDTO;
use Blog\Entity\Post;
use Blog\Entity\Comment;
use Blog\DTO\Post\PostDTO;
use Blog\DTO\Post\ListPostDTO;
use Blog\DTO\Comment\CommentDTO;
use Blog\DTO\Post\CreatePostDTO; 
use Blog\DTO\Post\SinglePostDTO;
use Blog\Service\Interface\Getter;
use Blog\DTO\Form\Post\PostCreationDTO;
use Blog\DTO\Entitie\Comment\CommentDTO;
use Doctrine\ORM\EntityManagerInterface;
use Blog\DTO\Entitie\Post\CompletePostDTO;
use Blog\DTO\Entitie\Post\PostModerationDTO;


class PostService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    public function createPost(CreatePostDTO $postToCreate, int $userId): int 
    {
        $user = UserService::getService($this->entityManager)->getUser($userId);
        $post = new Post($user, $postToCreate->content, $postToCreate->title, $postToCreate->excerpt);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $post->getId();
    }
    /**
     * @return SinglePostDTO
     */
    public function getSingle(int $id): CompletePostDTO 
    {
        $singlePost = $this->entityManager->find(Post::class, $id);
        return new CompletePostDTO($singlePost, $this->getComment($singlePost, CommentStatus::Approved)); 
    }
    /**
     * @return array<PostDTO>
     */
    public function getAll(): array
    {
        $postrepository = $this->entityManager->getRepository(Post::class);
        $posts = $postrepository->findAll();
        $constructor = fn (Post $post) =>  new PostDTO($post);
        return  \array_map($constructor(...), $posts);
    }
    /**
     *  @return array<SinglePostDTO>
     */
    public function getPostsCommentsPending(): array
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();
        $createSingleDTO = fn (Post $post) => new CompletePostDTO($post,$this->getComment($post,CommentStatus::Pending));
        return \array_map($createSingleDTO(...), $posts);
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
    
    /**
     * @return array<CommentDTO>
     */
    private function getComment(Post $post, CommentStatus $status): array
    {
        $getComment = fn($comment)=> new CommentDTO($comment);
        if (CommentStatus::Pending === $status) {
            $commentList = $post->getCommentPending()->toArray();
        } elseif (CommentStatus::Approved === $status) {
            $commentList = $post->getCommentApproved()->toArray();
        } else {
            //if we want other comments for now:
            throw new \Exception("not possible to retrieve this comments");
        } 
        return \array_map($getComment, $commentList);
    }
}
