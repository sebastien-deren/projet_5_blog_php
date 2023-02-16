<?php
namespace Blog\Controller\Admin;

use Blog\DTO\Post\PostDTO;
use Blog\Service\PostService;
use Blog\DTO\Post\SinglePostDTO;
use Blog\Form\EditPostValidifier;

class PostEditController extends EditController{
    public function execute(): string
    {
        $PostDto = (new EditPostValidifier(New SinglePostDTO,$_POST))->validify();
        $postService = new PostService($this->entityManager);
        $this->argument['message']= $postService->updatePost($PostDto);
        return parent::execute();
    }

}