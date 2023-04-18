<?php
namespace App\Services;
use App\DTOs\ProductTypeDTO;
use App\Entities\ProductType;
use App\Repositories\ProductTypeRepository;

class ProductTypeService
{
    private ProductTypeRepository $repository;

    public function list() : array
    {
        return $this->getRepository()->getAll();
    }

    public function create(string $bodyParams) : ProductTypeDTO
    {
        $jsonParams = json_decode($bodyParams, true);
        $producTypeObject = new ProductTypeDTO();
        $producTypeObject->name = $jsonParams['name'];
        $producTypeObject->taxPercentage = $jsonParams['taxPercentage']; 
        return $producTypeObject;

    }

    private function getRepository(): ProductTypeRepository
    {
        if (!isset($this->repository)) {
            $this->repository = new ProductTypeRepository();
        }
        return $this->repository;
    }
}