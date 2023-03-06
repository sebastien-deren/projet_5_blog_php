<?php

namespace Blog\Controller\User\Connection;


use Blog\Controller\AbstractController;
use Blog\Controller\Traits\Token;



class ConnectionController extends AbstractController
{
    use Token;
    public function execute() :?string
    {
        if(isset($_SESSION['id'])){
            \header("location: /");
        }
        $this->createToken();
        return $this->twig->render('@user/connection.html.twig',$this->argument);
    }
}
