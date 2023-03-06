<?php
session_start();

use Blog\Service\UserService;
use Blog\Controller\ErrorController;

require_once(dirname(__FILE__) . '/../bootstrap.php');

/**
 * we will find the controller linked to our route 
 * then we will call the execute method who will call the different method necessary to our page
 * finally the method will return a string who is our twig rendering pages and index will display it
 * 
 * This try catch is here to display all our exception thrown in our code and not catch before.
 * 
 */


if(isset($_SESSION['id'])){
    $userService =UserService::getService($entityManager);
    $twig->addGlobal('user',$userService->display($userService->getUser($_SESSION['id'])));
}

try {
    echo $router->getController()->execute();
} catch (\Exception $e) {
    $controllerErreur = new ErrorController($twig, $entityManager, $e);
    echo $controllerErreur->execute();
}
