<?php
namespace Blog\Test;

use Blog\Router\Path;
use Blog\Router\Router;
use Blog\Controller\IndexController;


require_once(dirname(__FILE__) . '/../bootstrap.php');
function testrouter($url,Router $router, Path $index){
    try{
        $controller = $router->FindTheController($url);
    }
    catch(\Exception $e){
        echo \PHP_EOL;
        echo $e->getMessage();
    }
    $router->initPath($index);
    
}

testrouter('admin/createpost',$router,$index);
testrouter('admin',$router,$index);
testrouter('admin/createpost/1234',$router,$index);
testrouter('admin/createpost/calle/jut',$router,$index);
testrouter('',$router,$index);
testrouter('frambpoise',$router,$index);
testrouter('admin/createpost/23/coucou',$router,$index);
testrouter('2345',$router,$index);
