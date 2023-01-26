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

    public function render()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->display();
            return;
        }
        $formLogin = new LoginForm(new LoginDTO);
        $userService = new UserService($this->entityManager);
        try {
            $userToLog = $formLogin->validify($_POST);
            $userId = $userService->log($userToLog);
            $_SESSION['id'] = $userId;
            \header("location: /");
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->display();
        }
    }
    private function display()
    {
        echo $this->twig->render('@user/connection.html.twig');
    }
}
