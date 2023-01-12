<?php
namespace Blog\Controller\User;

use Twig\Environment;
use Blog\Controller\Controller;

class ConnectionController implements Controller{
    public function __construct(private Environment $twig)
    {
        # code...
    }
    public function doYourThing(?int $id)
    {
        # code...
    }
    
}