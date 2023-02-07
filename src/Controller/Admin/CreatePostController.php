<?php

namespace Blog\Controller\Admin;

use Blog\Form\CreatePostForm;
use Blog\Service\PostService;
use Blog\Controller\Admin\AdminController;

class CreatePostController extends AdminController
{


    public function execute()
    {
        $template = $this->twig->load('@admin/createPost.html.twig');
        return $template->render($this->argument);

    }
}
