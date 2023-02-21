<?php

namespace Blog\Controller\User;

use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Blog\Controller\Abstracts\AbstractController;
use Blog\Controller\Traits\Token;

class ConnectionController extends AbstractController
{
    private ObjectRepository|EntityRepository $repoUser;
    use Token;
    public function execute(): ?string
    {
        $this->createToken();

        if (isset($_SESSION['id'])) {
            \header("location: /");
        }
        return $this->twig->render('@user/connection.html.twig', $this->argument);
    }
}
