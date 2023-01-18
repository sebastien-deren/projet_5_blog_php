<?php

namespace Blog\Controller\User;

use Exception;
use Blog\Service\UserService;
use Blog\Controller\Controller;
use Doctrine\ORM\EntityRepository;
use Blog\Model\Form\LoginFormModel;
use Doctrine\Persistence\ObjectRepository;


class ConnectionController extends Controller
{
    private ObjectRepository|EntityRepository $repoUser;

    public function execute()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->display();
            return;
        }
        $formLogin = new LoginFormModel;
        $userService = new UserService($this->entityManager);
        try {
            $userToLog = $formLogin->arrayToObjectUserLogin($_POST);
            $userId = $userService->loginUser($userToLog);
            $_SESSION['id']=$userId;
            \var_dump($_SESSION);
            echo $this->twig->render('@user/index.html.twig');
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->display();
        }
        

        /*
            we have a servor error when using header location we'll have to look into apache conf files. 
        \header("location : /");
        */
    }
    private function display()
    {
        echo $this->twig->render('@user/connection.html.twig');
    }
    private function checkLogin($login, $password) {
        if (\strchr($login, '@')) {
            $user = $this->repoUser->findOneBy(["mail" => $login]);
        } else {
            $user = $this->repoUser->findOneBy(["login" => $login]);
        }
        if (null == $user || !\password_verify($password, $user->getPassword())) {
            throw new Exception("le mot de passe ou l'utilisateur à mal été tapé");
        }
        $_SESSION['id'] = $user->getId();
    }
}
