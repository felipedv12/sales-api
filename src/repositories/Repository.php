<?php

namespace App\Repositories;

use Config\Database;
use Exception;
use PDO;
use PDOException;

class Repository
{
    protected PDO $db;

    public function __construct()
    {
        $driver = Database::DB_DRIVER;
        $host = Database::DB_HOST;
        $port = Database::DB_PORT;
        $dbname = Database::DB_NAME;
        $user = Database::DB_USER;
        $password = Database::DB_PASSWORD;

        $connectionString = "{$driver}:host={$host};port={$port};dbname={$dbname};user={$user};password={$password}";
        $this->connect($connectionString);
    }

    private function connect(string $connectionString) 
    {
        try {
            $this->db = new PDO($connectionString);
        } catch (PDOException $e) {
            http_response_code(500);
            $data = ['success'=> false, 'data' => null, 'message' => 'Error connecting to database, try again in a few minutes. ->' . $e->getMessage()];
            echo(json_encode($data));
            throw new Exception('Error connecting to database: ' . $e->getMessage());
        } 
    }
}