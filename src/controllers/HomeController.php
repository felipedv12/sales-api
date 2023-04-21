<?php
namespace App\Controllers;

class HomeController 
{
    /**
     * Returns some basic information about the API
     *
     * @return array
     */
    public function home() : array 
    {
        $data = ["message" => "Bem-vindo à Sales-API",
            "version" => "1.0.0",
            "author" => "Felipe Marques",
            "description" => "API para teste na SoftExpert",
            "repository" => [
              "type" => "git",
              "url" => "https://github.com/felipedv12/sales-api.git"
            ]
        ];
        http_response_code(200);
        return $data;
    }
}