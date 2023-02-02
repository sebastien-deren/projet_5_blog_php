<?php

namespace Blog\Controller\Blog;


use Blog\Entity\Post;
use Blog\Controller\Controller;
use Blog\Controller\AbstractController;
use Blog\Service\PostService;

class BlogListController extends AbstractController
{
    public function execute():string
    {
        $template = $this->twig->load('@blog/list.html.twig');

        $postService =new PostService($this->entityManager);
        $posts = $postService->getAll();
        return $template->render(["posts" => $posts]);
        }
}
