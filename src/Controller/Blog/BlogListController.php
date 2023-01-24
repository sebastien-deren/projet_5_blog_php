<?php

namespace Blog\Controller\Blog;

use Blog\Controller\Controller;
use Blog\Entity\Post;
use Blog\Service\PostService;
use Exception;

class BlogListController extends Controller
{
    public function render()
    {
        $template = $this->twig->load('@blog/list.html.twig');
        $postService = new PostService($this->entityManager);
        $posts = $postService->getAll();
        echo $template->render(["posts" => $posts]);
        }
}
