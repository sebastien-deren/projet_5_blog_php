<?php
namespace Blog\Controller;

use Exception;
use Blog\Entity\Post;
use Blog\Controller\Controller;
use Twig\Environment;

class PostController extends Controller{
    private Post $post;

    public function addpost($donneeEnvoye,$user){
            $this->post = new Post($user);
            $this->post->setContent( $donneeEnvoye['content']);
            $this->post->setTitle($donneeEnvoye['title']);
            $this->post->setExcerpt($donneeEnvoye['exerpt']);
            $this->post->setDate(\localtime());
        return $this->post;

    }
    public function setTwig(Environment $twig){
        $this->twig =$twig;
    }
    public function doYourThing()
    {
        //todo ajouter user
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $this->addpost($_POST,null);
            echo"on passe bien la";
        }
        if($_SERVER['REQUEST_METHOD']==='GET'){
            //dothings
        }
        return $this->twig->load("@admin/createPost.html.twig");
    }
}