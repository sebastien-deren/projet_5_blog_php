<?php
session_start();

require_once(dirname(__FILE__) . '/../bootstrap.php');
echo $router->getController()->execute();
