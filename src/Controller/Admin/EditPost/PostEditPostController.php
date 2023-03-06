<?php

namespace Blog\Controller\Admin\EditPost;

use Blog\DTO\Form\Post\PostEditionDTO;
use Blog\Service\PostService;
use Blog\Form\Post\EditPostValidifier;

class PostEditController extends EditController
{
    public function execute(): string
    {
        $PostDto = (new EditPostValidifier(new PostEditionDTO, $_POST))->validify();
        $postService = new PostService($this->entityManager);
        $this->argument['message'] = $postService->updatePost($PostDto);
        return parent::execute();
    }
}
