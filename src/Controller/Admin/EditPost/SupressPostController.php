<?php

declare(strict_types=1);

namespace Blog\Controller\Admin\EditPost;

use Blog\Service\PostService;
use Blog\Controller\Admin\AdminController;

class SupressPostController extends AdminController
{
    public function execute(): null
    {
        $postService = new PostService($this->entityManager);
        $postService->delete((int)$_GET["id"]);  
        \header("location: /admin/listpost");   
        return null;
    }

}
