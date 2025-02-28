<?php 
namespace App\Service;

use App\Models\Product;
use App\Repository\ProductRepository;
use Config\Database;
use App\Validator\Rules\PositiveNumberRule;
use App\Validator\Rules\RequiredRule;
use App\Validator\Validator;
use Exception;


class ProductService {
    private $repository;

    public function __construct() 
    {
        $database = new Database();
        $this->repository = new ProductRepository($database->connection());
    }

    public function insert(object $request) : array 
    {
        
        $validator = new Validator();
        $validator->addRule('name', new RequiredRule());
        $validator->addRule('price', new PositiveNumberRule());
        
        $data = [
            "name"          => property_exists($request, 'name') ? $request->name : "",
            "price"         => property_exists($request, 'price') ? $request->price : 0, 
            "description"   => property_exists($request, 'description') ? $request->description : ""
        ];

        if (!$validator->validate($data)) {

            return [
                'error' => $validator->getFirstError(),
                'product' => $data,
            ];
        }

        try {
            $product = new Product();
            $product->setName($data['name']);
            $product->setPrice($data['price']);
            $product->setDescription($data['description']);
            $id = $this->repository->insert($product);

        } catch ( Exception $excepetion ) {
            return [
                'error' => 'Erro ao cadastrar produto, tente novamente mais tarde.'
            ];
        }

        return [
            'success' => true, 
            'id' => $id
        ];
    }

    public function update(object $request) : array 
    {
       
        $validator = new Validator();
        $validator->addRule('name', new RequiredRule());
        $validator->addRule('price', new PositiveNumberRule());

        $data = [
            "name"          => property_exists($request, 'name') ? $request->name : "",
            "price"         => property_exists($request, 'price') ? $request->price : 0, 
            "description"   => property_exists($request, 'description') ? $request->description : ""
        ];
       

        if (!$validator->validate($data)) {

            return [
                'error' => $validator->getFirstError(),
                'product' => $data,
            ];
        }

        try {
            $product = new Product();
            $product->setName($data['name']);
            $product->setPrice($data['price']);
            $product->setDescription($data['description']);
            $product->setId($request->id);
            
            $id = $this->repository->update($product);

        } catch ( Exception $excepetion ) {
            return [
                'error' => 'Erro ao editar produto, tente novamente mais tarde.',
                'product' => $data,
            ];
        }
        return [
            'success' => true, 
            'id' => $id
        ];
    }

    public function getAllProducts() 
    {
        return $this->repository->getProducts();
    }

    public function countProductById(int $id) : int 
    {
        $result = $this->repository->countProductById($id);
        return $result['total'];
    }

    public function countProducts() : int 
    {
        $result = $this->repository->countProducts();
        return $result['total'];
    }

    public function getProductsPaginated($currentPage) : array 
    {
        $data['totalRecordsPerPage']    = 10;
        $data['totalRecords']           = $this->countProducts();
        $data['totalPages']             = ceil($data['totalRecords'] / $data['totalRecordsPerPage']);
        $data['page']                   = $currentPage;
        $offset                         = ($currentPage - 1) * $data['totalRecordsPerPage'];
        $products                       = $this->repository->getProductsPaginated($data['totalRecordsPerPage'], $offset);
        $data['products']               = $products;
        
        return $data;
    }

    
    public function delete($id) : array 
    {
        try { 
            $rowsEffected = $this->repository->delete($id);
            if($rowsEffected < 1) {
                return ['error' => 'Erro ao deletar produto, tente novamente mais tarde', 'rowsEffected' => $rowsEffected];
            }
        } catch (Exception $e) {
            return ['error' => 'Erro ao deletar produto, tente novamente mais tarde'];
        }
        return ['success' => $rowsEffected];
    }

    public function show(int $id) : array 
    {
        $result = $this->repository->getProduct($id);
        if ($result === false) {
            return ['error' => 'Produto nao encontrado'];
        }
        return ['product' => $result];
    }

}