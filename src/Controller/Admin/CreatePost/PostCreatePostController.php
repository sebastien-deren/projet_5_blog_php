<?php

namespace Blog\Controller\Admin\CreatePost;

use Blog\Controller\Admin\AdminController;
use Blog\Service\PostService;
use Blog\Exception\FormException;
use Blog\Form\Post\CreatePostForm;
use Blog\DTO\Form\Post\PostCreationDTO;

class PostCreatePostController extends AdminController
{
    public function execute(): null
    {
        try {
            $formvalidifier = new CreatePostForm(new PostCreationDTO, $_POST);
            $post = $formvalidifier->validify();
            $postService = new PostService($this->entityManager);
            $id = $postService->createPost($post, $_SESSION['id']);
            \header('location: /blog/post?id='.$id.'');
        } catch (FormException $e) {
            $this->argument['error'] = $e;
        }
        return null;
    }
}
