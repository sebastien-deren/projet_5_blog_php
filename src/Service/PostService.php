<?php

namespace Blog\Service;

use Blog\Entity\Post;
use Blog\Enum\CommentStatus;
use Blog\Service\CommentService;
use Blog\DTO\Post\PostDisplayDTO;

class PostService extends Service
{
    public function getPostsCommentsPending(): array
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();
        return \array_map($this->getCommentToModerate(...), $posts);
    }
    private function getCommentToModerate($post): ?PostDisplayDTO
    {
        $getComment=CommentService::getService($this->entityManager)->getCommentDTO(...); 
        $commentList = $post->getCommentPending()->toArray();
        $commentsToModerate = \array_map($getComment, $commentList);
        if ([] === $commentsToModerate) {
            return null;
        }
        return $this->getPostDTO($post, $commentsToModerate);

    }
    private function getPostDTO(Post $post,array $comments =[]){
        $postDTO = new PostDisplayDTO;
        $postDTO->comments = $comments;
        $postDTO->authorName = $post->getUser()->getFirstname() . " " . $post->getUser()->getLastname();
        $postDTO->title = $post->getTitle();
        $postDTO->date = \date_format($post->getDate(), "Y-m-d h:i:s");
        return $postDTO;
    }
}
