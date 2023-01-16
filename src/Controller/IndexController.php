<?php
namespace Blog\Controller;

use Twig\Environment;
use Blog\Controller\Controller;


class IndexController extends Controller{

    public function render(){
        echo $this->twig->render('@user/index.html.twig');
    }
}