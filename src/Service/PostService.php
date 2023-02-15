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
use Blog\DTO\Post\createPostDTO;
use Blog\DTO\Post\SinglePostDTO;
use Blog\Service\Interface\Getter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;

class PostService
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
    /**
     * @return SinglePostDTO
     */
    public function getSingle($id): SinglePostDTO
    {
        $singlePost = $this->entityManager->find(Post::class, $id);
        return new SinglePostDTO($singlePost,$this->getComment($singlePost,CommentStatus::Approved));
    }
    /**
     * @return array<PostDTO>
     */
    public function getBy(?array $param = null): array
    {
        $postrepository = $this->entityManager->getRepository(Post::class);
        $posts = null === $param ? $postrepository->findAll() : $postrepository->find($param);
        $constructor = fn ($a) =>  new PostDTO($a);
        return  \array_map($constructor(...), $posts);
    }
    /**
     *  @return array<SinglePostDTO>
     */
    public function getPostsCommentsPending(): array
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();
        $createSingleDTO = fn ($a) => new SinglePostDTO($a,$this->getComment($a,CommentStatus::Pending));
        return \array_map($createSingleDTO(...), $posts);
    }
    /**
     * @return array<CommentDTO>
     */
    private function getComment(Post $post, CommentStatus $status): array
    {
        $getComment = CommentService::getService($this->entityManager)->createDTO(...);
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
