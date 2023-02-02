<?php

namespace Blog\Controller\User;


use Exception;
use Blog\Form\LoginForm;
use Blog\DTO\User\LoginDTO;
use Blog\Service\UserService;
use Blog\Controller\Controller;
use Doctrine\ORM\EntityRepository;
use Blog\Model\Form\LoginFormModel;
use Blog\Controller\AbstractController;
use Doctrine\Persistence\ObjectRepository;


class ConnectionController extends AbstractController
{
    private ObjectRepository|EntityRepository $repoUser;

    public function execute()
    {
        if(isset($_SESSION['id'])){
            \header("location: /");
        }
        $this->addFieldSession(['token' => \md5(\uniqid(\mt_rand(), true))]);
        $this->argument['csrfToken'] = $_SESSION['token'];
        return $this->twig->render('@user/connection.html.twig',$this->argument);
    }
}
