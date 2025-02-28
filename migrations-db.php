<?php 
require __DIR__. "/vendor/autoload.php";

use Config\Config;

return [
    'dbname' => Config::getEnv('DB_NAME'),
    'user' => Config::getEnv('DB_USERNAME'),
    'password' => Config::getEnv('DB_PASSWORD'),
    'host' => Config::getEnv('DB_HOST'),
    'driver' => 'pdo_mysql',
];