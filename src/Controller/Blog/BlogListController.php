<?php

namespace Blog\Controller\Blog;

use Blog\Controller\Controller;
use Blog\Entity\Post;
use Blog\Service\PostService;
use Blog\Controller\AbstractController;

class BlogListController extends AbstractController
{
    public function execute()
    {
        $postService = new PostService($this->entityManager);
        $posts = $postService->getAll();
        echo $this->twig->render('@blog/list.html.twig',["posts" => $posts]);
        }
}
