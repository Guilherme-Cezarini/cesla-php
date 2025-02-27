<?php 
namespace App\Controller;

use App\Service\ProductService;

class ProductController extends Controller {

    private $service;

    public function __construct() {  
        $this->service = new ProductService();
    }
    
    public function index($request) {
        $page = isset($request->page) ? $request->page : 1;
        $result = $this->service->getProductsPaginated($page);
        $this->view('index', 'products',['products' => $result['products'], 'totalPages' => $result['totalPages']]);
        return;
    }

    public function create($request) {
        $this->view('create', 'products',[]);
        return;
    }

    public function show($request) {
        $response = $this->service->show($request->id);
        if(isset($response['error'])) {

            $_SESSION['error-flash-messages'] = $response['error'];
            header('Location: /produtos');
            return;
        }
        $this->view('show', 'products',['product' => $response['product']]);
        return;
    }

    public function update($request) {
        $result = $this->service->update($request);
        
        if(array_key_exists('error', $result)) {
            $this->view('show', 'products', ['errors' => $result['error'], 'product' => $result['product']]);
            return;
        }
        $_SESSION['success-flash-messages'] = "Produto editado com sucesso";
        header('Location: /produtos');
        return;
       
    }

    public function store($request) {

        $result = $this->service->insert($request);
        
        if(array_key_exists('error', $result)) {
            $this->view('create', 'products', ['errors' => $result['error'], 'product' => $result['product']]);
            return;
        }
        $_SESSION['success-flash-messages'] = "Produto cadastrado com sucesso";
        header('Location: /produtos');
        return;
    }

    public function delete($request) {
    
        $result = $this->service->delete($request->id);
        if (isset($result['error']))
        {   
            $_SESSION['error-flash-messages'] = $result['error'];
            header('Location: /produtos');
            return;
        }

        $_SESSION['success-flash-messages'] = "Produto deletado com sucesso";
        header('Location: /produtos');
        return;
    }

}
