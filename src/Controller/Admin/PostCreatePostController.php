<?php

namespace Blog\Controller\Admin;

use Blog\Form\CreatePostForm;
use Blog\Service\PostService;
use Blog\DTO\Post\CreatePostDTO;

class PostCreatePostController extends CreatePostController
{
    public function execute():string
    {

        $formvalidifier = new CreatePostForm(new CreatePostDTO);
        $post = $formvalidifier->validify($_POST);

        $postService = new PostService($this->entityManager);
        $postService->CreatePost($post);

        $this->argument['post'] = $post;
        $this->argument['message']= "post envoyé dans la base de donnée";
        return parent::execute();
    }
}
