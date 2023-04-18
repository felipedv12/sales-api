<?php

namespace App\Repositories;

use Config\Database;
use PDO;

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
        $this->db = new PDO($connectionString);
    }
}