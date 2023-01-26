<?php
namespace Blog\Controller;



class IndexController extends AbstractController{

    public function render(){
        echo $this->twig->render('@user/index.html.twig');
    }
}