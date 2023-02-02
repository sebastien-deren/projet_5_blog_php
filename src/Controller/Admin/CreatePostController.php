<?php

namespace Blog\Controller\Admin;

<<<<<<< HEAD
use Exception;



use Blog\Service\PostService;
use Blog\Controller\Controller;
use Blog\Form\CreatePostForm;


class CreatePostController extends Controller
{


    public function render()
    {
        $template = $this->twig->load('@admin/createPost.html.twig');
        if (empty($_SERVER['REQUEST_METHOD'])) {
            $id = empty($id) ? 'aucun' : $id;
            throw new \Exception("on a pas de call du server, si c'est un test on est dans " . self::class . "argument envoyé " . $id);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formvalidifier = new CreatePostForm();
            $postService = new PostService($this->entityManager);
            try {
                $postDTO = $formvalidifier->ArrayToObjectPostCreationDTO($_POST);
                $postId= $postService->CreatePost($postDTO);
            } catch (Exception $e) {
                echo $template->render(['error' => $e->getMessage()]);
            }
            //TODO edit this header to link to our newly created post page (and not the list of all post)
            // \header("location: /blog/post?id=".$postId);
            \header("location: /blog");
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo $template->render();
        }
=======

use Doctrine\ORM\EntityManager;
use Blog\Controller\AbstractController;

class CreatePostController extends AbstractController
{
    private EntityManager $entity;




    public function execute():string
    {
        $template =$this->twig->load('@admin/createPost.html.twig');
        return $template->render();
>>>>>>> ce892771683db92c70b3a9836030ec5ba39b6c03
        //return $this->twig->load("@admin/createPost.html.twig");
    }
}
