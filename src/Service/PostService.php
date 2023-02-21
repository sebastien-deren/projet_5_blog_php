<?php

namespace Blog\Service;

use Blog\Entity\Post;
use Blog\Entity\User;
use Blog\DTO\Post\PostDTO;
use Blog\Enum\CommentStatus;
use Blog\DTO\Comment\CommentDTO;
use Blog\DTO\Post\createPostDTO;
use Blog\DTO\Post\SinglePostDTO;
use Blog\DTO\Post\UpdatePostDTO;
use Blog\Service\CommentService;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    public function CreatePost(CreatePostDTO $postToCreate, int $userId): int
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
    public function getSingle($id): SinglePostDTO
    {
        $singlePost = $this->entityManager->find(Post::class, $id);
        return new SinglePostDTO($singlePost, $this->getComment($singlePost, CommentStatus::Approved));
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


    public function getPostsCommentsPending(): array
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();
        $createSingleDTO = fn (Post $post) => new SinglePostDTO($post, $this->getComment($post, CommentStatus::Pending));
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

    public function updatePost(UpdatePostDTO $postUpdate)
    {
        $postStocked = $this->entityManager->find(Post::class, $postUpdate->id);
        if ($postUpdate->title !== $postStocked->getTitle()) {
            $postStocked->setTitle($postUpdate->title);
        }
        if ($postUpdate->content !== $postStocked->getcontent()) {
            $postStocked->getContent($postUpdate->content);
        }
        if ($postUpdate->authorId !== $postStocked->getUser()->getId()) {
            $postStocked->setUser($this->entityManager->find(User::class, $postUpdate->authorId));
        }
        if ($postUpdate->excerpt !== $postStocked->getExcerpt()) {
            $postStocked->setExcerpt($postUpdate->excerpt);
        }
        return $this->entityManager->flush();
    }
}
