<?php

namespace Blog\Controller\Admin;


use Blog\Controller\Traits\Token;
use Blog\Controller\Abstracts\AdminController;

class CreatePostController extends AdminController
{
    use Token;

    public function execute():string
    {
        
       $this->createToken();
        $template = $this->twig->load('@admin/createPost.html.twig');
        return $template->render($this->argument);

    }
}
