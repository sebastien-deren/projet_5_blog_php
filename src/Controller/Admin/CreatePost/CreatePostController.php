<?php

namespace Blog\Controller\Admin\CreatePost;

use Blog\Controller\Admin\AdminController;
use Blog\Controller\Traits\Token;

class CreatePostController extends AdminController
{

use Token;
    public function execute(): string
    {
        $this->createToken();
        $template = $this->twig->load('@admin/createPost.html.twig');
        return $template->render($this->argument);
    }
}
