<?php
namespace Blog\Controller;

use Doctrine\ORM\EntityManager;
use Twig\Environment;
use Twig\Template;

interface ControllerInterface  
{
    public function getModel(EntityManager $entityManager);
    public function render();
}