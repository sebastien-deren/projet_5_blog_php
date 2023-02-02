<?php

namespace Blog\Controller\Admin;


use Doctrine\ORM\EntityManager;
use Blog\Controller\AbstractController;

class CreatePostController extends AbstractController
{
    private EntityManager $entity;




    public function execute():string
    {
        $template =$this->twig->load('@admin/createPost.html.twig');
        return $template->render();
        //return $this->twig->load("@admin/createPost.html.twig");
    }
}
