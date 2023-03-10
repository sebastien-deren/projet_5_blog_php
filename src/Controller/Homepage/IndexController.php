<?php

namespace Blog\Controller\Homepage;

use Blog\Controller\Traits\Token;
use Blog\Controller\AbstractController;



class IndexController extends AbstractController
{

    use Token;
    public function execute(): string
    {
        $this->createToken();
        return $this->twig->render('@user/index.html.twig', $this->argument);
    }
}
