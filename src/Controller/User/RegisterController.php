<?php

namespace Blog\Controller\User;

use Blog\Service\UserService;
use Blog\Form\UserRegisterForm;
use Blog\DTO\User\UserCreateDTO;
use Blog\DTO\User\UserUpdateDTO;
use Blog\Exception\FormException;
use Blog\DTO\User\UserRegisterDTO;
use Blog\Controller\AbstractController;
use Blog\Controller\Form\CreaterController;
use Blog\Controller\Interface\ReceivingPost;

class RegisterController extends AbstractController implements ReceivingPost
{
    public function execute()
    {
        try {
            $handler = new CreaterController(
                new UserService($this->entityManager),
                new UserRegisterForm(
                    new UserCreateDTO(
                        new UserRegisterDTO,
                        new UserUpdateDTO
                    )
                )
            );
            $handler->handleform($_POST);
            //TODO change it to /connection when connection issue is done
            header("location: /");
        } catch (FormException $e) {
            //TODO make a reusable template to display error in different pages
            echo ['@user/register.html.twig', ['error' => $e]];
        }
    }
    public function render()
    {
        echo $this->twig->render('@user/register.html.twig',["javascript"=>"pahtToJs"]);
    }
}
