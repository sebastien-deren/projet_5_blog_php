<?php

namespace Blog\Controller\Admin\EditPost;

use Blog\Service\PostService;
use Blog\Service\UserService;
use Blog\Controller\Traits\Token;
use Blog\Controller\Admin\AdminController;

class EditController extends AdminController
{
    Use Token;
    public function execute():string
    {
        $this->createToken();
        $postId = isset($_GET['id']) ? $_GET['id'] : throw new \InvalidArgumentException('pas de post');
        \is_numeric($postId) ?: throw new \InvalidArgumentException('not an id');
        $postService = new PostService($this->entityManager);
        $userService= UserService::getService( $this->entityManager) ;
        $this->argument['post'] = $postService->getSingle($postId);
        $this->argument['admins'] = $userService->getAdmins();
        return $this->twig->render('@admin/post.html.twig', $this->argument);
    }
}
