<?php


use Twig\Environment;
use Blog\Router\Router;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Twig\Loader\FilesystemLoader;
use Blog\Exception\RouterException;

use Doctrine\DBAL\DriverManager;
use Twig\Loader\FilesystemLoader;
use Blog\Controller\PostController;
use Blog\Exception\RouterException;
use Blog\Controller\IndexController;


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
/*create the tree of our site we just have to add a subdomain to be checked by our router,
 if none exist for now our router throw a RouterException, and then will redirect us to our index.
 We will need to take into account the $_METHOD to link our controller.
 and we might add a callable or a controller directly into our subdomain*/
 $index= $router->setDomain(null, new IndexController($twig));
 $admin = $index->addSubdomain('admin');
 $connection = $index->addSubdomain('connection');
 $blog = $index->addSubdomain('blog');
 $create_post = $admin->addFinalPath('createpost',new PostController($twig));
 $comment = $admin->addSubdomain('comment');
 $comment->subDomainIdentifiable();
 $post = $blog->addSubdomain('post');
 $post->subDomainIdentifiable();

