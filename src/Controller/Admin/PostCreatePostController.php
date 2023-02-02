<?php

namespace Blog\Controller\Admin;

use Blog\Entity\Post;
use Blog\Controller\Controller;

class PostCreatePostController extends Controller
{
    public function execute():string
    {


        $e = new \Exception("le formulaire est mal rempli");
        $fields = [];

        foreach ($_POST as $fieldKey => $fieldValue) {
            $fields[$fieldKey] = !empty(\htmlspecialchars($fieldValue)) ? $fieldValue : throw $e;
        }
        $userId = !empty($_SESSION['id']) ? $_SESSION['id'] : 2;
        $user = $this->entityManager->find('\Blog\Entity\User', $userId);

        $post = new Post($user);
        $post->addpost($fields);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return  $this->twig->render('@admin/createPost.html.twig',[
            "post" => $post,
            "message" => 'post envoyé dans la base de donnée'
        ]);
    }
}
