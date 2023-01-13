<?php

require_once(dirname(__FILE__) . '/../bootstrap.php');
//$user = $entityManager->find('\Blog\Entity\User',2);
try{

    $controllername =$router->getController($_GET['url']);
    $controller = new $controllername($twig,$entityManager);
    $controller->render();
    }

    catch(Exception $e){

        $render= $twig->load('@user/index.html.twig');
        $render->display(["error"=> $e]);
    }
