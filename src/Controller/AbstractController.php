<?php

namespace Blog\Controller;


use Twig\Environment;
use Doctrine\ORM\EntityManager;
use Blog\Controller\Interface\ControllerInterface;

abstract class AbstractController implements ControllerInterface
{
    protected array $argument=[];

    public function __construct(protected Environment $twig, protected EntityManager $entityManager)
    {
        if(!empty($_SESSION)) {
            $this->protectSession();
        }
        
    }
    abstract public function execute():?string;

    /**
     * Check if the new page is called by the same client
     * @return void
     */
    protected function protectSession():void
    {
        
        if($_SERVER['REMOTE_ADDR'] !== $_SESSION['ipAddress']) {
            \session_unset();
            \session_destroy();
            return;
        }
        if($_SERVER['HTTP_USER_AGENT']!==$_SESSION['userAgent']) {
            \session_unset();
            \session_destroy();
            return;
        }
    }
    /**
     * Adding a field to our global variable $_SESSION
     * 
     * @param array<string> $data the value of _POST
     * 
     * @return void
     */
    protected function addFieldSession(array $data)
    {
        $_SESSION['ipAddress']=$_SERVER['REMOTE_ADDR'];
        $_SESSION['userAgent']=$_SERVER['HTTP_USER_AGENT'];
        $_SESSION =\array_merge($data, $_SESSION);
    }
}
