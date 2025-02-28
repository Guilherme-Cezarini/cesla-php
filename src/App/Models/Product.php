<?php 
namespace App\Models;

class Product { 

    private $price;
    private $name;
    private $description;
    private $id;

    public function getId() 
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id; 
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price; 
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description; 
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name; 
    }

}