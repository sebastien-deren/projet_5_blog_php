<?php

namespace Blog\Controller\User;

use Blog\Entity\User;
use Twig\Environment;
use Blog\Controller\Controller;

class UserController extends Controller
{
    private User $user;

    public function addUser(Array $property):User
    {
        $this->user =new User;
        $this->user->setFirstname($property["firstname"]);
        $this->user->setLastname($property["lastname"]);
        $this->user->setMail($property["mail"]);
        $this->user->setRole($property["role"]);
        $this->user->setPassword($property["password"]);
        $this->user->setLogin(\strval(\rand(0,200)));
        return $this->user;
    }
    public function createView(?int $id)
    {
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $this->addUser($_POST);
        }
        if($_SERVER['REQUEST_METHOD']==='GET'){
            //dothings
        }
        return 'createPost.html.twig';
    }
}
