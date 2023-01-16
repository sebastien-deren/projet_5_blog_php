<?php
namespace Blog\Controller;

use Twig\Template;
use Doctrine\ORM\EntityManager;
use Blog\Controller\ControllerInterface;
use Twig\Environment;

abstract class Controller implements ControllerInterface{
    protected array $argument;
    public function __construct(protected Environment $twig, protected EntityManager $entityManager)
    {
        
    }
    public function getModel(EntityManager $entityManager){

    }
    public function render(){
        echo 'coucou';
        
    }

}