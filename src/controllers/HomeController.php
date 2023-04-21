<?php
namespace App\Controllers;
use App\Utils\Consts;

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
        http_response_code(Consts::HTTP_CODE_OK);
        return $data;
    }
}