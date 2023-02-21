<?php
namespace Blog\Controller\Abstracts;

use Blog\Entity\User;
use Blog\Enum\RoleEnum;
use Blog\Service\UserService;
use Blog\Controller\Abstracts\AbstractController;

abstract class AdminController extends AbstractController{
    public function __construct($twig,$entityManager)
    {
        
        if(!isset($_SESSION['id'])||RoleEnum::ADMIN !== UserService::getService($entityManager)->getRole($_SESSION['id'])){
            throw new \Exception("vous n'avez pas l'autorisation nécessaire pour acceder à cette page",403);
        }
        parent::__construct($twig,$entityManager);
    }
}