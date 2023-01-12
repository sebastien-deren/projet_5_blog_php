<?php

use Blog\Test;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Blog\Controller\PostController;
use Blog\Controller\UserController;
use Blog\Entity\User;
use Blog\Exception\RouterException;

require_once(dirname(__FILE__) . '/../bootstrap.php');


$template = $twig->load("/admin/createPost.html.twig");
$user = $entityManager->find('\Blog\Entity\User',2);
echo is_object($user);
echo is_a($user,'Blog\Entity\User');
if(empty($_GET['url'])){
    $_GET['url'] ='admin/createpost';
}

/*create the tree of our site we just have to add a subdomain to be checked by our router,
 if none exist for now our router throw a RouterException, and then will redirect us to our index.
 We will need to take into account the $_METHOD to link our controller.
 and we might add a callable or a controller directly into our subdomain*/
$index= $router->setDomain(null);
$admin = $index->addSubdomain('admin');
$connection = $index->addSubdomain('connection');
$blog = $index->addSubdomain('blog');
$create_post = $admin->addSubdomain('createpost');
$comment = $admin->addSubdomain('comment');
$comment->subDomainIdentifiable();
$post = $blog->addSubdomain('post');
$post->subDomainIdentifiable();

try{

    $route =$router->findOurRoute($_GET['url'],$_SERVER['REQUEST_METHOD']);
    echo $route;
    }
    catch(Exception $e){
        echo $e->getMessage();
    }


/*base routing need to create a real router*/
if ($_GET['url'] === 'admin/index.php') {
    if (isset($_POST)) {
        $postController = new PostController;
        $post = $postController->addpost($_POST,$user);
        $entityManager->persist($post);
        $entityManager->flush();
        
        echo "le post a été ajouté";
    }
}
if ($_GET['url'] === 'admin/createPost') {
    $template = $twig->load("@admin/createPost.html.twig");
    echo $template->render();
} else {
    $template = $twig->load("@user/index.html.twig");
    echo $template->render();
}
