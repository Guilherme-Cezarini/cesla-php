<?php
namespace App\Response;



class ApiJsonResponse implements Response
{
    public function mount(int $statusCode, array $data)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        if(!empty($data)) {
            echo json_encode($data);
        }
    }
}