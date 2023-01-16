<?php
namespace Blog\Controller\Admin;

use Blog\Entity\Post;
use Blog\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Exception;
use Twig\Environment;

class PostCreaterController extends Controller{
    private Post $post;
    private EntityManager $entity;


    public function addpost($donneeEnvoye,$user){
            $this->post = new Post($user);
            $this->post->setContent( $donneeEnvoye['content']);
            $this->post->setTitle($donneeEnvoye['title']);
            $this->post->setExcerpt($donneeEnvoye['exerpt']);
            $this->post->setDate(\localtime());
        return $this->post;

    }

    public function render()
    {
        if(empty($_SERVER['REQUEST_METHOD'])){
            $id =empty($id) ? 'aucun' :$id;
            throw new \Exception("on a pas de call du server, si c'est un test on est dans ". self::class. "argument envoyé " .$id);
        }
        //todo ajouter user
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $e =New Exception("le formulaire est mal rempli");
            $fields =[];
            foreach($_POST as $field){

            }
            $fields['content'] = !empty(\htmlspecialchars( $_POST['content'])) ? $_POST['content'] :throw $e; 
            //$creater =new CreaterPost($fields);
            
            echo"on passe bien la";
        }
        if($_SERVER['REQUEST_METHOD']==='GET'){
            //dothings
        }
        //return $this->twig->load("@admin/createPost.html.twig");
    }
}