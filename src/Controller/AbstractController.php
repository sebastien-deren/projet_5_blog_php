<?php
namespace Blog\Controller;

use Doctrine\ORM\EntityManager;
use Blog\Controller\ControllerInterface;
use Twig\Environment;

abstract class AbstractController implements ControllerInterface{
    protected array $argument=[];
    public function __construct(protected Environment $twig, protected EntityManager $entityManager)
    {
        
    }

}