<?php

use Blog\Test;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Blog\Controller\PostController;
use Blog\Controller\UserController;
use Blog\Entity\User;
use Blog\Exception\RouterException;
use function Blog\Test\testrouter;

require_once(dirname(__FILE__) . '/../bootstrap.php');
$user = $entityManager->find('\Blog\Entity\User',2);
try{

    $route =$router->findOurRoute($_GET['url']);
    echo $route->render();
    }
    catch(Exception $e){
        echo $e->getMessage();
        echo "</br>retour à index";
         $render= $twig->load('@user/index.html.twig');
        $render->display();
    }
