<?php

use Blog\Test;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Blog\Controller\PostController;
use Blog\Controller\UserController;
use Blog\Entity\User;
use Blog\Exception\RouterException;

require_once(dirname(__FILE__) . '/../bootstrap.php');

<<<<<<< HEAD

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

$dir_template = dirname(__FILE__, 2) . '/template';
$loader = new FilesystemLoader($dir_template);
$loader->addPath($dir_template . "/admin", "admin");
$loader->addPath($dir_template . "/user", "user");
$twig = new Environment($loader, ['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension);
$template = $twig->load("/admin/createPost.html.twig");
$user = $entityManager->find('\Blog\Entity\User',2);

>>>>>>> 14cc5f9 (adding subpathfinal)

try{

    $route =$router->findOurRoute($_GET['url'],$_SERVER['REQUEST_METHOD']);
    echo $route->render();
    }
    catch(Exception $e){
        echo $e->getMessage();
        echo "</br>retour à index";
    }



/*base routing need to create a real router*/
/*if ($_GET['url'] === 'admin/index.php') {
    if (isset($_POST)) {
        $postController = new PostController($twig);
        $post = $postController->addpost($_POST,$user);
        $entityManager->persist($post);
        $entityManager->flush();
        
        echo "le post a été ajouté";
    }
}*/
