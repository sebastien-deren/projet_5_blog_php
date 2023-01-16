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
        $template =$this->twig->load('@admin/createPost.html.twig');
        if (empty($_SERVER['REQUEST_METHOD'])) {
            $id = empty($id) ? 'aucun' : $id;
            throw new \Exception("on a pas de call du server, si c'est un test on est dans " . self::class . "argument envoyé " . $id);
        }
        //todo ajouter user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $e = new Exception("le formulaire est mal rempli");
            $fields = [];
            
            //try {
                foreach ($_POST as $fieldKey => $fieldValue) {
                    $fields[$fieldKey] = !empty(\htmlspecialchars($fieldValue)) ? $fieldValue : throw $e;
                }
                $userId = !empty($_SESSION['id']) ? $_SESSION['id'] : 2;
                $user = $this->entityManager->find('\Blog\Entity\User', $userId);

                $post = new Post($user);
                $post->addpost($fields);
                $this->entityManager->persist($post);
                $this->entityManager->flush();
                echo $template->render([
                    "post" => $post,
                    "message"=> 'post envoyé dans la base de donnée'
                ]);
         /*   } catch (Exception $e) {
                echo $template->render(['error' => $e->getMessage()]);
            }*/

        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo $template->render();
        }
        //return $this->twig->load("@admin/createPost.html.twig");
    }
}
