<?php
namespace Blog\Controller\Blog;

use Twig\Environment;
use Blog\Controller\Controller;
use Blog\Service\PostService;

class PostController extends Controller{
public function execute(){
   $postId = isset($_GET['id'])?$_GET['id']:throw new \InvalidArgumentException('pas de post');
   \is_numeric($postId)?:throw new \InvalidArgumentException('not an id');
   $postService = new PostService($this->entityManager);
   $post = $postService->getByID($postId);
    $this->twig->display('@blog/post.html.twig',['post'=>$post]);

}