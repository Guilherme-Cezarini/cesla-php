<?php 
namespace App\Repository;

use App\Models\Product;
use PDO;
use PDOException;

class ProductRepository {

    private $db;
    private $table="products";

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function insert(Product $product,)
    {

        $sql = "INSERT INTO " . $this->table .  " (name, price, description) VALUES (:name, :price, :description)";
        $insert = $this->db->prepare($sql);
        $insert->bindValue(':name', $product->getName());
        $insert->bindValue(':price', $product->getPrice());
        $insert->bindValue(':description', $product->getDescription());

        $insert->execute();
        
        return $this->db->lastInsertId();
    
    }

    public function update(Product $product)
    {

        $sql = "UPDATE " . $this->table .  " SET name = :name, description = :description, price = :price WHERE id = :id ";
        $insert = $this->db->prepare($sql);
        $insert->bindValue(':name', $product->getName());
        $insert->bindValue(':price', $product->getPrice());
        $insert->bindValue(':description', $product->getDescription());
        $insert->bindValue(':id', $product->getId());

        $insert->execute();
        
        return $this->db->lastInsertId();
    
    }

    public function getProducts() : array
    {
        $sql = "SELECT id, name, price, description FROM ". $this->table;
        $select = $this->db->prepare($sql);
       

        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM ". $this->table . " WHERE id = :id";
        $delete = $this->db->prepare($sql);
        $delete->bindValue(':id', $id);

        $delete->execute();

        return $delete->rowCount();
    
    }

    public function countProductById(int $id ) : array 
    {
        $sql = "SELECT COUNT(*) AS total FROM " . $this->table . " WHERE id = :id";  
        $count = $this->db->prepare($sql);
        $count->bindValue(":id", $id);

        $count->execute();

        return $count->fetch(PDO::FETCH_ASSOC);
    }

    public function countProducts() : array 
    {
        $sql = "SELECT COUNT(*) AS total FROM " . $this->table;
        $count = $this->db->prepare($sql);
        

        $count->execute();

        return $count->fetch(PDO::FETCH_ASSOC);
    }

    public function getProduct($id) 
    {
        $sql = "SELECT id, name, price, description FROM ". $this->table . " WHERE id= :id ";
        $select = $this->db->prepare($sql);
        $select->bindValue(':id', $id);

        $select->execute();
       
      
        return $select->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductsPaginated(int $limit, int $offset) : array 
    {
        $sql = "SELECT id, name, description, price FROM ". $this->table . " LIMIT :limit OFFSET :offset";
        $select = $this->db->prepare($sql);
        $select->bindValue(':limit', $limit, PDO::PARAM_INT);
        $select->bindValue(':offset', $offset, PDO::PARAM_INT);
        $select->execute();


        return $select->fetchAll(PDO::FETCH_ASSOC);
    }
    
}