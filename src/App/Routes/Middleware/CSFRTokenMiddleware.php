<?php
namespace App\Routes\Middleware;

use Exception;

class CSFRTokenMiddleware implements Middleware 
{
    public function run()
    {
        if (!isset($_REQUEST['csrf_token']) ||$_REQUEST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception("CSFR token invalido");
        }
    }
}