<?php

namespace Blog\Controller;

use Twig\Environment;
use Blog\Controller\Controller;
use Blog\Controller\ControllerInterface;
use Doctrine\ORM\EntityManager;

class ErrorController extends AbstractController
{
    public function __construct(Environment $twig,EntityManager $entityManager, private \Exception $error)
    {
        parent::__construct($twig, $entityManager);
    }
    public function execute(): string
    {
        return $this->twig->render('error.html.twig', ["error" => $this->error]);
    }
}
