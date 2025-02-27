<?php 
namespace App\Models;

class Product { 

    private $price;
    private $name;
    private $description;
    private $id;

    public function getId() : int 
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id; 
    }

    public function getPrice() : float 
    {
        return $this->price;
    }

    public function setPrice(float $price)
    {
        $this->price = $price; 
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description; 
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name; 
    }

}