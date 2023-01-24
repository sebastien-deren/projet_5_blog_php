<?php


use Twig\Environment;
use Blog\Router\Router;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Twig\Loader\FilesystemLoader;
use Blog\Controller\Blog\PostController;
use Blog\Controller\Blog\BlogListController;
use Blog\Controller\User\ConnectionController;
use Blog\Controller\Admin\CreatePostController;
use Blog\Controller\Admin\CommentAdminController;
require_once(dirname(__FILE__) . '/vendor/autoload.php');

/*creation of our entity manager*/
$paths = [dirname(__FILE__) . '/src/Entity'];
$isDevMode = true;
$dbParams = [
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => 'root',
    'dbname' => 'test',
    'host' => 'mysql'
];
$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);


/*creation of our twig renderer*/
$dir_template = dirname(__FILE__) . '/template';
$loader = new FilesystemLoader($dir_template);
$loader->addPath($dir_template . "/admin", "admin");
$loader->addPath($dir_template . "/user", "user");
$loader->addPath($dir_template."/blog", "blog");
$twig = new Environment($loader, ['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension);


/* creation of our router*/
$router = new Router();
$router->addPath('connection', ConnectionController::class);
$router->addPath('admin/createpost', CreatePostController::class);
$router->addPath('admin/comment', CommentAdminController::class);
$router->addPath('blog/post',PostController::class);
$router->addPath('blog',BlogListController::class);