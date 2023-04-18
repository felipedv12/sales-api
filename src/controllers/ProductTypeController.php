<?php
namespace App\Controllers;
use App\DTOs\ProductTypeDTO;
use App\Services\ProductTypeService;

class ProductTypeController
{
    private ProductTypeService $service;

    public function list(): array
    {
        $status = 200;
        $results = $this->getService()->list();
        if(empty($results)){
            $status = 404;
        }
        http_response_code($status);
        return $results;
    }

    public function create(string $bodyParams) : ProductTypeDTO
    {

        $result = $this->getService()->create($bodyParams);
        return $result;
    }

    private function getService(): ProductTypeService
    {
        if (!isset($this->service)) {
            $this->service = new ProductTypeService();
        }
        return $this->service;
    }
}