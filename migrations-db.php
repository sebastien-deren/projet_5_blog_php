<?php

use Doctrine\DBAL\DriverManager;

/**
 * We should create another mysql container to stock our migrations files for better security
 */
return DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => 'root',
    'dbname' => 'test',
    'host' => 'mysql'
]);
