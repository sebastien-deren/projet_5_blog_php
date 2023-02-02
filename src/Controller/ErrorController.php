<?php
namespace Blog\Controller;

use Blog\Controller\Controller;
use Blog\Controller\ControllerInterface;

class ErrorController extends Controller{
    public function __construct($twig,$entityManager,private \Exception $error)
    {
        parent::__construct($twig,$entityManager);
        
    }
    public function execute(): string
    {
        return $this->twig->render('error.html.twig',["error"=>$this->error]);
    }

}