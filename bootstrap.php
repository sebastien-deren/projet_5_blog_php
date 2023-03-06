<?php


use Blog\Enum\Method;
use Twig\Environment;
use Blog\Router\Router;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Twig\Loader\FilesystemLoader;

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
$loader->addPath($dir_template . "/blog", "blog");
$twig = new Environment($loader, ['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension);
$twig->addGlobal("CSS",'blog/css');


/* creation of our router*/

$method = Method::tryFrom($_SERVER['REQUEST_METHOD'])??Method::GET;
$router = new Router($_GET['url']??"",$method,$twig,$entityManager);


//HOMEPAGE ROUTE

//index Route
$router->addPath('', Blog\Controller\Homepage\IndexController::class);
$router->addPath('',Blog\Controller\Homepage\PostIndexController::class,Method::POST);


//USER ROUTE

/*connection Route */
$router->addPath('connection', Blog\Controller\User\Connection\ConnectionController::class);
$router->addPath('connection',Blog\Controller\User\Connection\PostConnectionController::class,Method::POST);

//deconnection Route
$router->addPath('deconnection',Blog\Controller\User\Connection\DeconnectionController::class);

//registers Route
$router->addPath('register',Blog\Controller\User\Register\RegisterController::class);
$router->addPath('register',Blog\Controller\User\Register\PostRegisterController::class,Method::POST);


//BLOG ROUTE

//blog list route
$router->addPath('blog',Blog\Controller\Blog\BlogListController::class);

//single blog post Route
$router->addPath('blog/post',Blog\Controller\Blog\ArticleController::class);
$router->addPath('blog/post',Blog\Controller\Blog\PostArticleController::class,Method::POST);


//ADMIN ROUTE

//CreatePosts Route
$router->addPath('admin/createpost', Blog\Controller\Admin\CreatePost\CreatePostController::class);
$router->addPath('admin/createpost',Blog\Controller\Admin\CreatePost\PostCreatePostController::class,Method::POST);

//comment moderation Route
$router->addPath('admin/comment', Blog\Controller\Admin\ModerateComment\CommentModerationController::class);
$router->addPath('admin/comment',Blog\Controller\Admin\ModerateComment\PostCommentModerationController::class,Method::POST);

//edit Post Route
$router->addPath('admin/listpost',Blog\Controller\Admin\EditPost\ListPostController::class);
$router->addPath("admin/supress_post",Blog\Controller\Admin\EditPost\SupressPostController::class);
$router->addPath('admin/post',Blog\Controller\Admin\EditPost\EditController::class);
$router->addPath('admin/post',Blog\Controller\Admin\EditPost\PostEditController::class,Method::POST);
