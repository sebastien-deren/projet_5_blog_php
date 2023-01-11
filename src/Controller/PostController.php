<?php
namespace Blog\Controller;

use Blog\Entity\Post;
use Exception;

class PostController{
    private Post $post;
    public function addpost($donneeEnvoye,$user){
            $this->post = new Post($user);
            $this->post->setContent( $donneeEnvoye['content']);
            $this->post->setTitle($donneeEnvoye['title']);
            $this->post->setExcerpt($donneeEnvoye['exerpt']);
            $this->post->setDate(\localtime());
        return $this->post;

    }
}