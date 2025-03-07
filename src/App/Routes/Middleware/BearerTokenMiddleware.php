<?php 
namespace App\Routes\Middleware;

use Config\Config;

class BearerTokenMiddleware implements Middleware
{
    private $bearerToken;

    public function __construct()
    {
        $this->bearerToken = Config::getEnv('BEARER_TOKEN');
    }

    public function run()
    {
        if(!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            header('Content-Type: application/json');
            http_response_code(401);
            $data['error'] = 'Unautorized';
            echo json_encode($data);
            exit; 
        }

        $token = str_replace("Bearer ", "", $_SERVER['HTTP_AUTHORIZATION']);
        if($token != $this->bearerToken || $this->bearerToken == "") {
            header('Content-Type: application/json');
            http_response_code(401);
            $data['error'] = 'Unautorized';
            echo json_encode($data);
            exit; 
        }
    }
}