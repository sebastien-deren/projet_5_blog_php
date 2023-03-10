<?php

namespace Blog\Controller\Blog;

use Blog\Service\PostService;
use Blog\Controller\AbstractController;
use Blog\Controller\Traits\Token;

class ArticleController extends AbstractController
{
    use Token;
    public function execute():string
    {
        $this->createToken();
        $postId = isset($_GET['id']) ? $_GET['id'] : throw new \InvalidArgumentException('pas de post');
        \is_numeric($postId) ?: throw new \InvalidArgumentException('not an id');
        $postService = new PostService($this->entityManager);
        $this->argument['post'] = $postService->getSingle($postId);
        return $this->twig->render('@blog/post.html.twig', $this->argument);
    }
}
