<?php
namespace Blog\Controller;

use Twig\Template;
use Doctrine\ORM\EntityManager;
use Blog\Controller\ControllerInterface;

abstract class Controller implements ControllerInterface{
    private array $argument;
    public function getModel(EntityManager $entityManager){

    }
    public function render(){
        echo 'coucou';
        
    }

}