<?php

namespace Blog\Controller;


use Twig\Environment;
use Doctrine\ORM\EntityManager;
use Blog\Controller\Interface\Controller;

abstract class AbstractController implements Controller
{
    protected array $argument;
    public function __construct(protected Environment $twig, protected EntityManager $entityManager)
    {
    }
    abstract public function render();
}
