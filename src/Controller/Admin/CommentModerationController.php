<?php

declare(strict_types=1);

namespace Blog\Controller\Admin;

use Blog\Enum\CommentStatus;
use Blog\Service\PostService;
use Blog\Controller\Traits\Token;
use Blog\Controller\AbstractController;

class CommentModerationController extends AdminController
{
    use Token;
    public function execute():string
    {
        try {
            $this->argument['csrfToken'] = $this->create();
            $postService = new PostService($this->entityManager);
            $this->argument['posts'] = $postService->getPostsCommentsPending();
        } catch (\InvalidArgumentException $e) {
            $this->argument['information'] = $e->getMessage();
        }
        return $this->twig->render('@admin/commentModeration.html.twig', $this->argument);
    }
}
