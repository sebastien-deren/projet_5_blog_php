<?php

namespace Blog\Controller\User;

use Blog\Controller\Controller;
use Blog\Exception\FormException;
use Blog\Model\UserConstructor;

class RegisterController extends Controller
{
    public function render()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user = new UserConstructor($_POST);
                $user = $user->getUser();
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                echo $this->twig->render('@user/connection.html.twig');
            } catch (FormException $e) {
                //TODO make a reusable template to display error in different pages
                echo $this->twig->render('@user/register.html.twig', ['error' => $e]);
            }

        } else {
            echo $this->twig->render('@user/register.html.twig');
        }
    }
}
