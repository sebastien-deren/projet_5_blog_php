<?php
namespace Blog\Router;

use Blog\Controller\Controller;
use Blog\Router\Path;

class PathFinal extends Path{
    public function __construct($name,private Controller $controller)
    {
      parent::__construct($name);   
    }
    public function callController(?string $id){
        return $this->controller->doYourThing($id);
    }
}