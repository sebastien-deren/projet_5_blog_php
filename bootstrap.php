<?php


use Twig\Environment;
use Blog\Router\Router;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Twig\Loader\FilesystemLoader;
use Blog\Controller\PostController;
use Blog\Controller\IndexController;
use Blog\Controller\User\ConnectionController;
use Blog\Controller\Admin\PostCreaterController;
use Blog\Controller\Admin\CommentAdminController;


require_once(dirname(__FILE__).'/vendor/autoload.php');

$paths =[dirname(__FILE__).'/src/Entity'];
$isDevMode = true;
$dbParams=[
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password'=>'root',
    'dbname' =>'test',
    'host'=> 'mysql'
];
$config = ORMSetup::createAttributeMetadataConfiguration($paths,$isDevMode);
$connection = DriverManager::getConnection($dbParams,$config);
$entityManager= new EntityManager($connection,$config);



$dir_template = dirname(__FILE__) . '/template';
$loader = new FilesystemLoader($dir_template);
$loader->addPath($dir_template . "/admin", "admin");
$loader->addPath($dir_template . "/user", "user");
$twig = new Environment($loader, ['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension);

$router = new Router();
/*create the tree of our site we just have to add a subpath to be checked by our router,
 if none exist for now our router throw a RouterException, and then will redirect us to our index.
 We will need to take into account the $_METHOD to link our controller.
 and we might add a callable or a controller directly into our subpath*/
 $index= $router->setPath(null, new IndexController($twig));
 $admin = $index->addSubPath('admin');
 $connection = $index->addFinalPath('connection',new ConnectionController($twig));
 $blog = $index->addSubPath('blog');
 $create_post = $admin->addFinalPath('createpost',new PostCreaterController($twig));
 $comment = $admin->addFinalPath('comment',new CommentAdminController($twig));
 $comment->subPathIdentifiable();
 $post = $blog->addFinalPath('post',new PostController($twig));
 $post->subPathIdentifiable();

