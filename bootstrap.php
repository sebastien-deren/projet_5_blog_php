<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

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
