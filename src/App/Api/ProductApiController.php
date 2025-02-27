<?php
namespace App\Api;

use App\Service\ProductService;

class ProductApiController
{
    private $service;

    public function __construct() {  
        $this->service = new ProductService();
    }

    public function products($request)
    {
        $page = isset($request->page) ? $request->page : 1;
        $response = $this->service->getProductsPaginated($page);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode($response);
        return;
    }

    public function product($request)
    {
        $id = $request->url_params['id'];
        $response = $this->service->show($id);
        if(isset($response['error'])){
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $response['error']]);
            return;
        }
        $data['data'] = $response['product'];
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode($data);
        return;
    }

    public function update($request)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $data['id'] = $request->url_params['id'];
        $countItem = $this->service->countProductById($data['id']);
        if ($countItem == 0) {
            $response['error'] = "Produto nao encontrado";
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode($response);
            return;
        }

        $result = $this->service->update((object)$data);
        if(isset($result['error'])) {
            $response['error'] = $result['error'];
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode($response);
            return;
        }
        header('Content-Type: application/json');
        http_response_code(200);    
        return;
       
    }

    public function create($request)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $result = $this->service->insert((object)$data);
       
        if(isset($result['error'])) {
            $response['error'] = $result['error'];
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode($response);
            return;
        }
        header('Content-Type: application/json');
        http_response_code(201);    
        return;
       
    }

    public function delete($request)
    {
        $id = $request->url_params['id'];
        $result = $this->service->delete($id);
        if(isset($result['error'])) {
            
            if($result["rowsEffected"] < 1) {
                $response['error'] = "Produto nao encontrado";
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode($response);
                return;
            }
            header('Content-Type: application/json');
            $response['error'] = $result['error'];
            http_response_code(400);
            echo json_encode($response);
            return;
        }
        header('Content-Type: application/json');
        http_response_code(200);    
        return;
       
    }




}