<?php

declare(strict_types=1);

namespace Blog\Controller\Admin;

use Blog\Service\PostService;
use Blog\Controller\Admin\ListPostController;
use Doctrine\ORM\EntityNotFoundException;

class SupressPostController extends AdminController
{
    public function execute(): null
    {
        $postService = new PostService($this->entityManager);
        $postService->delete($_GET["id"]);  
        \header("location: /admin/listpost");   
        return null;
    }

}
