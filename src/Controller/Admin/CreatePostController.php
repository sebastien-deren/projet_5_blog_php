<?php

namespace Blog\Controller\Admin;

use Exception;
use CreaterPost;
use Blog\Entity\Post;
use Twig\Environment;
use Blog\Controller\Controller;
use Blog\Entity\User;
use Doctrine\ORM\EntityManager;

class CreatePostController extends Controller
{
    private EntityManager $entity;




    public function execute():string
    {
        $template =$this->twig->load('@admin/createPost.html.twig');
        return $template->render();
        //return $this->twig->load("@admin/createPost.html.twig");
    }
}
