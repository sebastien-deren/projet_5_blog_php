<?php

namespace Blog\Controller\Admin;

use Blog\Form\CreatePostForm;
use Blog\Service\PostService;
use Blog\DTO\Form\Post\PostCreationDTO;



class PostCreatePostController extends CreatePostController
{
    public function execute():string
    {

        $formvalidifier = new CreatePostForm(new PostCreationDTO);
        $post = $formvalidifier->validify($_POST);

        $postService = new PostService($this->entityManager);
        $postService->CreatePost($post,$_SESSION['id']);

        $this->argument['post'] = $post;
        $this->argument['message']= "post envoyé dans la base de donnée";
        return parent::execute();
    }
}
