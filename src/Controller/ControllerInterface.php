<?php
namespace Blog\Controller;

use Doctrine\ORM\EntityManager;
use Twig\Environment;
use Twig\Template;
use Twig\TemplateWrapper;

interface ControllerInterface  
{

    public function execute():string;
}
