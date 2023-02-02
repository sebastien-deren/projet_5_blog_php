<?php

namespace Blog\Controller;



class IndexController extends AbstractController{

    public function execute(): string
    {
       return $this->twig->render('@user/index.html.twig');
    }
}
