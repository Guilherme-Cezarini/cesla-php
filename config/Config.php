<?php 
namespace Config;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();

class Config 
{ 
    
    public static function getEnv(string $index)
    {
        $array = [
            'DB_HOST'       => $_ENV['DB_HOST'],
            'DB_NAME'       => $_ENV['DB_DATABASE'],
            'DB_USERNAME'   => $_ENV['DB_USERNAME'],
            'DB_PASSWORD'   => $_ENV['DB_PASSWORD'],
            'BEARER_TOKEN'  => isset($_ENV['BEARER_TOKEN']) ? $_ENV['BEARER_TOKEN'] : "",
        ];

        return $array[$index];
    }
}