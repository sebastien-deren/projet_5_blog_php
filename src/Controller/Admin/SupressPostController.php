<?php

declare(strict_types=1);

namespace Blog\Controller\Admin;

use Blog\Service\PostService;
use Blog\Controller\Admin\ListPostController;
use Doctrine\ORM\EntityNotFoundException;

class SupressPostController extends ListPostController
{
    public function execute(): string
    {
        try{
        $postService = new PostService($this->entityManager);
        $postService->delete($_GET["id"]);  
        \header("location: /admin/listpost");
        }
        catch(EntityNotFoundException $e){
            $this->argument['error']=$e;
        }
        return parent::execute(); 
    }

}
