<?php
namespace Blog\Test;

use Blog\Router\Router;


require_once(dirname(__FILE__) . '/../bootstrap.php');
function testrouter($url,Router $router){
    try{
        $router->FindTheController($url);
    }
    catch(\Exception $e){
        echo \PHP_EOL;
        echo $e->getMessage();
    }
}
testrouter('admin/createpost',$router);
testrouter('admin',$router);
testrouter('admin/createpost/1234',$router);
testrouter('admin/createpost/calle/jut',$router);
testrouter('',$router);
testrouter('frambpoise',$router);
testrouter('admin/createpost/23/coucou',$router);
testrouter('2345',$router);