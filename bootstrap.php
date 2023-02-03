<?php


use Blog\Enum\Method;
use Twig\Environment;
use Blog\Router\Router;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Twig\Loader\FilesystemLoader;
use Blog\Controller\PostController;
use Blog\Controller\Blog\BlogListController;
use Blog\Controller\User\RegisterController;
use Blog\Controller\User\ConnectionController;
use Blog\Controller\Admin\CreatePostController;
use Blog\Controller\User\PostRegisterController;
use Blog\Controller\Admin\PostCreatePostController;
use Blog\Controller\Admin\CommentModerationController;
use Blog\Controller\Admin\PostCommentModerationController;


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
$loader->addPath($dir_template. "/composant", "composant");
$loader->addPath($dir_template . "/admin", "admin");
$loader->addPath($dir_template . "/user", "user");
$loader->addPath($dir_template."/blog", "blog");
$twig = new Environment($loader, ['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension);


/* creation of our router*/
$method = Method::tryFrom($_SERVER['REQUEST_METHOD'])??Method::GET;
$router = new Router($_GET['url']??"/",$method,$twig,$entityManager);
$router->addPath('connection', ConnectionController::class);
$router->addPath('admin/createpost', CreatePostController::class);
$router->addPath('admin/createpost',PostCreatePostController::class,Method::POST);
$router->addPath('admin/comment', CommentModerationController::class);
$router->addPath('admin/comment',PostCommentModerationController::class,Method::POST);
$router->addPath('blog/post',PostController::class);
$router->addPath('blog',BlogListController::class);
$router->addPath('register',RegisterController::class);
$router->addPath('register',PostRegisterController::class,Method::POST);