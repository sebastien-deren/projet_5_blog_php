<?php

use Blog\Controller\Interface\FormHandler;
use Blog\Controller\Interface\ReceivingPost;

require_once(dirname(__FILE__) . '/../bootstrap.php');
echo $router->getController()->execute();
