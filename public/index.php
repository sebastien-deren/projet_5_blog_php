<?php
session_start();

require_once(dirname(__FILE__) . '/../bootstrap.php');
use Blog\Service\UserService;

if(isset($_SESSION['id'])){
    $userService =new UserService($entityManager);
    $twig->addGlobal('user',$userService->display($_SESSION['id']));
}
try{

    $controllername =$router->getController($_GET['url']);
    $controller = new $controllername($twig,$entityManager);
    $controller->render();
    }

    catch(Exception $e){

        $render= $twig->load('@user/index.html.twig');
        $render->display(["error"=> $e]);
    }
