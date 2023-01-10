<?php

use Blog\Test;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Blog\controller\PostController;
use Blog\controller\UserController;
use Blog\Entity\User;

require_once(dirname(__FILE__) . '/../bootstrap.php');

$dir_template = dirname(__FILE__, 2) . '/template';
$loader = new FilesystemLoader($dir_template);
$loader->addPath($dir_template . "/admin", "admin");
$loader->addPath($dir_template . "/user", "user");
$twig = new Environment($loader, ['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension);
$template = $twig->load("/admin/createPost.html.twig");
$user = $entityManager->find('\Blog\Entity\User',2);
echo is_object($user);
echo is_a($user,'Blog\Entity\User');
/*$listOfThings=["lastname"=>"nom","firstname"=>"prenom","mail"=>"mail","password"=>"pswd","role"=>0];
$userController = new UserController;
$user = $userController->addUser($listOfThings);
$entityManager->persist($user);*/



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
