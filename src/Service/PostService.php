<?php

namespace Blog\Service;

use Blog\Entity\Post;
use Blog\DTO\Post\createPostDTO;

class PostService extends Service
{
    public function CreatePost(CreatePostDTO $postToCreate): int
    {

        /*here do we want a DTO? I think we need a entity/User.
        If we send it only to our entity post I think it's ok to send an User entity 
        */

        $post = new Post($postToCreate->user, $postToCreate->content, $postToCreate->title, $postToCreate->excerpt);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $post->getId();
    }
}
