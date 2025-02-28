<?php
namespace App\Api;

use App\Service\ProductService;
use App\Response\ApiJsonResponse;

class ProductApiController
{
    private $service;
    private $responseMount;

    public function __construct() {  
        $this->service = new ProductService();
        $this->responseMount = new ApiJsonResponse();
    }

    public function products($request)
    {
        $page = isset($request->page) ? $request->page : 1;
        $response = $this->service->getProductsPaginated($page);
        $this->responseMount->mount(200, $response);
        return;
    }

    public function product($request)
    {
        $id = $request->url_params['id'];
        $response = $this->service->show($id);
        if(isset($response['error'])){
            $this->responseMount->mount(400, ['error' => $response['error']]);
            return;
        }

        $data['data'] = $response['product'];
        $this->responseMount->mount(200, $data);
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
            $this->responseMount->mount(400, $response);
            return;
        }

        $result = $this->service->update((object)$data);
        if(isset($result['error'])) {
            $response['error'] = $result['error'];
            $this->responseMount->mount(400, $response);
            return;
        }

        $this->responseMount->mount(200, []);
    
        return;
       
    }

    public function create($request)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $result = $this->service->insert((object)$data);
       
        if(isset($result['error'])) {
            $response['error'] = $result['error'];
            $this->responseMount->mount(400, $response);
    
            return;
        }
        $this->responseMount->mount(200, []);

        return;
       
    }

    public function delete($request)
    {
        $id = $request->url_params['id'];
        $result = $this->service->delete($id);
        if(isset($result['error'])) {
            
            if($result["rowsEffected"] < 1) {
                $response['error'] = "Produto nao encontrado";
                $this->responseMount->mount(400, $response);

                return;
            }
            $this->responseMount->mount(400, $result);
            return;
        }
        $this->responseMount->mount(200, []);

        return;
       
    }




}