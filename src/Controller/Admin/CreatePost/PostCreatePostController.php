<?php

namespace Blog\Controller\Admin\CreatePost;

use Blog\Service\PostService;
use Blog\Exception\FormException;
use Blog\Form\Post\CreatePostForm;
use Blog\DTO\Form\Post\PostCreationDTO;

class PostCreatePostController extends CreatePostController
{
    public function execute(): string
    {
        try {
            $formvalidifier = new CreatePostForm(new PostCreationDTO, $_POST);
            $post = $formvalidifier->validify();
            $postService = new PostService($this->entityManager);
            $postService->createPost($post, $_SESSION['id']);
            $this->argument['post'] = $post;
        } catch (FormException $e) {
            $this->argument['error'] = $e;
        }
        return parent::execute();
    }
}
