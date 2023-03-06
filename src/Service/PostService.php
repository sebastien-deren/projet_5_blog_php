<?php

namespace Blog\Service;

use Blog\Entity\Post;
use Blog\Enum\CommentStatus;
use Blog\DTO\Post\SinglePostDTO;
use Blog\DTO\Entity\Post\PostDTO;
use Blog\DTO\Form\Post\PostCreationDTO;
use Blog\DTO\Entity\Comment\CommentDTO;
use Doctrine\ORM\EntityManagerInterface;
use Blog\DTO\Entity\Post\CompletePostDTO;
use Blog\DTO\Entity\Post\PostModerationDTO;


class PostService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    public function createPost(PostCreationDTO $postToCreate, int $userId): int 
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


    public function getPostsCommentsPending(): array
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();
        $createSingleDTO = fn (Post $post) => new CompletePostDTO($post,$this->getComment($post,CommentStatus::Pending));
        $array = \array_map($createSingleDTO(...), $posts);
        return $array;
    }

    public function delete($id){
        $post =$this->entityManager->find(Post::class, $id)??throw new EntityNotFoundException("post not found");
        $this->entityManager->remove($post);
        $this->entityManager->flush();
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
