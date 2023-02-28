<?php
session_start();
use Blog\Service\UserService;
use Blog\Controller\ErrorController;

require_once dirname(__FILE__) . '/../bootstrap.php';

/**
 * We will find the controller linked to our route 
 * we will call the execute method
 * this will return a string, our twig rendering pages,
 * Index will display it
 * This try catch is here to display all our exception thrown in our code and not catch before.
 */


if (isset($_SESSION['id'])) {
    $userService =UserService::getService($entityManager);
    $twig->addGlobal('user', $userService->display($_SESSION['id']));
}

try{
    echo $router->getController()->execute();
}
catch( \ErrorException $e){
        $controllerErreur = new ErrorController($twig, $entityManager, $e);
        echo $controllerErreur->execute();
}
