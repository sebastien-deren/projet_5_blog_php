<?php
namespace Blog\Controller\Admin;

use Blog\Service\PostService;

class ListPostController extends AdminController{
    public function execute():string{
        $postService = new PostService($this->entityManager);
        $this->argument['posts'] = $postService->getAll();
        return $this->twig->render('@admin/editpost.html.twig', $this->argument);
    }
    
}