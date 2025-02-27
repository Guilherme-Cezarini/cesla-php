<?php 
namespace Config;

use PDO; 
use PDOException;

class Database { 
    private $host; 
    private $db_name; 
    private $username; 
    private $password;
    private $conn;

    public function __construct()
    {
        $this->host     = Config::getEnv('DB_HOST');
        $this->db_name  = Config::getEnv('DB_NAME');
        $this->username = Config::getEnv('DB_USERNAME');
        $this->password = Config::getEnv('DB_PASSWORD');
    }
    

    public function connection() {

        $this->conn = null;
        try {
            $pdo_host = "mysql:host=". $this->host . ";dbname=". $this->db_name;
            $this->conn = new PDO($pdo_host, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $exception){
        
            die("Database.php line 20 - Conexão falhou: " . $exception->getMessage());
            
        }

        return $this->conn;
        
    }
}