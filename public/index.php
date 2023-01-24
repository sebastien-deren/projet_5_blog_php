<?php
session_start();

use Blog\Controller\ErrorController;
use Blog\Controller\Interface\FormHandler;
use Blog\Controller\Interface\ReceivingPost;

use Blog\Controller\ErrorController;

session_start();
require_once(dirname(__FILE__) . '/../bootstrap.php');
try{
    echo $router->getController()->execute();
}catch(\Exception $e){
     echo (new ErrorController($twig,$entityManager,$e))->execute();
}

