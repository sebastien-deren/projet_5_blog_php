<?php

namespace Blog\Controller\Admin;

use Exception;
use CreaterPost;
use Blog\Entity\Post;
use Twig\Environment;
use Blog\Controller\Controller;
use Blog\Entity\User;
use Doctrine\ORM\EntityManager;

class PostCreaterController extends Controller
{
    private EntityManager $entity;




    public function render()
    {
        if (empty($_SERVER['REQUEST_METHOD'])) {
            $id = empty($id) ? 'aucun' : $id;
            throw new \Exception("on a pas de call du server, si c'est un test on est dans " . self::class . "argument envoyé " . $id);
        }
        //todo ajouter user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $e = new Exception("le formulaire est mal rempli");
            $fields = [];
            try {
                foreach ($_POST as $fieldKey => $fieldValue) {
                    $fields[$fieldKey] = !empty(\htmlspecialchars($fieldValue)) ? $fieldValue : throw $e;
                }
                $userId = !empty($_SESSION['id']) ? $_SESSION['id'] : 2;
                $user = $this->entityManager->find('\Blog\Entity\User', $userId);

                $post = new Post($user);
                $post->addpost($fields);
                $this->entityManager->persist($post);
                $this->entityManager->flush();
            } catch (Exception $e) {
                echo $e->getMessage();
                echo $this->twig->render('@admin/createPost.html.twig', ['error' => $e->getMessage()]);
            }

            echo $this->twig->render('@admin/createPost.html.twig', [$post, 'post envoyé dans la base de donnée']);
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo $this->twig->render('@admin/createPost.html.twig');
            //dothings
        }
        //return $this->twig->load("@admin/createPost.html.twig");
    }
}
