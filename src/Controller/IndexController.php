<?php
namespace Blog\Controller;

use Twig\Environment;
use Blog\Controller\Controller;

class IndexController implements Controller{
    public function __construct(private Environment $twig){}
    public function createView(?int $id){

        return  $this->twig->load("@user/index.html.twig");
    }
    
}