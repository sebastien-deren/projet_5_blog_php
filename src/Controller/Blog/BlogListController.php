<?php

namespace Blog\Controller\Blog;

use Blog\Service\PostService;
use Blog\Controller\Abstracts\AbstractController;

class BlogListController extends AbstractController
{
    public function execute():string
    {
        $template = $this->twig->load('@blog/list.html.twig');
        $postService = new PostService($this->entityManager);
        $this->argument['posts'] = $postService->getAll();
        return $template->render($this->argument);
    }
}
