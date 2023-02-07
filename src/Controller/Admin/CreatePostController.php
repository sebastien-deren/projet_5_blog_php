<?php

namespace Blog\Controller\Admin;

use Doctrine\ORM\EntityManager;
use Blog\Controller\Admin\AdminController;

class CreatePostController extends AdminController
{
    private EntityManager $entity;




    public function execute():string
    {
        $template =$this->twig->load('@admin/createPost.html.twig');
        return $template->render();
        //return $this->twig->load("@admin/createPost.html.twig");
    }
}
