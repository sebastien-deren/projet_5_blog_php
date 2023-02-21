<?php
namespace Blog\Controller\Default;

use Blog\Controller\Abstracts\AbstractController;

class ErrorController extends AbstractController{
    public function __construct($twig,$entityManager,private \Exception $error)
    {
        parent::__construct($twig,$entityManager);
        
    }
    public function execute(): string
    {
        return $this->twig->render('error.html.twig',["error"=>$this->error]);
    }

}