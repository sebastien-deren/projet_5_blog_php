<?php

namespace Blog\Controller\Admin;

use Blog\Service\PostService;
use Blog\Controller\AbstractController;

class EditController extends AdminController
{
    public function execute():string
    {
        $this->addFieldSession(['token' => \md5(\uniqid(\mt_rand(), true))]);
        $this->argument['csrfToken'] = $_SESSION['token'];
        $postId = isset($_GET['id']) ? $_GET['id'] : throw new \InvalidArgumentException('pas de post');
        \is_numeric($postId) ?: throw new \InvalidArgumentException('not an id');
        $postService = new PostService($this->entityManager);
        $this->argument['post'] = $postService->getBy(["id"=>$postId]);
        return $this->twig->render('@admin/post.html.twig', $this->argument);
    }
}
