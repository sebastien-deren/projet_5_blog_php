<?php

namespace Blog\Controller\Admin;

use Blog\Service\PostService;
use Blog\DTO\Post\CreatePostDTO;
use Blog\Form\Post\CreatePostForm;

class PostCreatePostController extends CreatePostController
{
    public function execute():string
    {

        $formvalidifier = new CreatePostForm(new CreatePostDTO, $_POST);
        $post = $formvalidifier->validify();

        $postService = new PostService($this->entityManager);
        $postService->CreatePost($post);

        $this->argument['post'] = $post;
        $this->argument['message']= "post envoyé dans la base de donnée";
        return parent::execute();
    }
}
