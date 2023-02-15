<?php

namespace Blog\Controller\Blog;

use Blog\Service\PostService;
use Blog\Controller\AbstractController;

class ArticleController extends AbstractController
{
    public function execute()
    {
        $this->addFieldSession(['token' => \md5(\uniqid(\mt_rand(), true))]);
        $this->argument['csrfToken'] = $_SESSION['token'];
        $postId = isset($_GET['id']) ? $_GET['id'] : throw new \InvalidArgumentException('pas de post');
        \is_numeric($postId) ?: throw new \InvalidArgumentException('not an id');
        $postService = new PostService($this->entityManager);
        $this->argument['post'] = $postService->getBy(["id"=>$postId]);
        $this->twig->display('@blog/post.html.twig', $this->argument);
    }
}
