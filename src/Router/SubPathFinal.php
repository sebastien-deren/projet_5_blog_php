<?php
namespace Blog\Router;

use Blog\Controller\Controller;
use Blog\Router\Domain;

class SubPathFinal extends Domain{
    public function __construct($name,private Controller $controller)
    {
      parent::__construct($name);   
    }
    public function callController(){
        return $this->controller->doYourThing();
    }
}