<?php

namespace Blog\Service;

use Blog\Entity\Post;
use Blog\Entity\Comment;
use Blog\Enum\CommentStatus;
use Blog\Service\CommentService;
use Blog\DTO\Post\PostDisplayDTO;

class PostService extends Service
{
    private CommentStatus $commentStatus = CommentStatus::Approved;
    public function getPostListWithComment(CommentStatus $commentStatus): array
    {
        $this->commentStatus = $commentStatus;
        $postRepository = $this->getRepository();
        $posts = $postRepository->findAll();
        $postList = $this->getPostsDTO($posts);


        return $postList;
    }

    private function getRepository()
    {
        return $this->entityManager->getRepository(Post::class);
    }
    private function getPostsDTO($posts): array
    {
        foreach ($posts as $post) {

            $postList[] = $this->createPostDTO($post);
        }
        return $postList;
    }
    private function createPostDTO($post):PostDisplayDTO
    {
        $postDTO = new PostDisplayDTO;
        $postDTO->comments = CommentService::getCommentsByValidity($post->getComment(),$this->commentStatus);
        $postDTO->authorName = $post->getUser()->getFirstname() . " " . $post->getUser()->getLastname();
        $postDTO->title = $post->getTitle();
        $postDTO->date = \date_format($post->getDate(), "Y-m-d h:i:s");
        return $postDTO;
    }
}
