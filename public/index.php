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
//$user = $entityManager->find('\Blog\Entity\User',2);
try{
    var_dump($_GET);

    $controller =$router->getController($_GET['url']);
    }

    catch(Exception $e){
        echo $e->getMessage();
        echo "</br>retour à index";
         $render= $twig->load('@user/index.html.twig');
        $render->display();
    }
try{
    //$controller->setParameter($twig,$entityManager,$_SERVER[__METHOD__],$_GET);


    }
    catch(Exception $e){
        echo"erreur";
    }