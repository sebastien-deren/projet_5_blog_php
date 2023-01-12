<?php
namespace Blog\Controller;

use Blog\Controller\Controller;

class IndexController extends Controller{
    public function doYourThing(){

        return  $this->twig->load("@user/index.html.twig");
    }
    
}