<?php
namespace App\Services;

use App\Entities\ProductType;
use App\Repositories\ProductTypeRepository;
use App\Validators\ProductTypeValidator;

class ProductTypeService
{

    private ProductTypeRepository $repository;

    private ProductTypeValidator $validator;

    /**
     * Method responsible for getting all registers of the table
     *
     * @return array Array list of ProductType objects
     */
    public function list(): array
    {
        $results = $this->getRepository()->getAll();
        return $results;
    }

    /**
     * Get product type by ID
     *
     * @param integer $id
     * @return array
     */
    public function find(int $id): array
    {
        $results = $this->getRepository()->findById($id);
        return $results;
    }

    /**
     * Receive the request and dispatch to the correct method
     *
     * @param string $bodyParams
     * @param integer $id
     * @return array|null
     */
    public function preparePersist(string $bodyParams, int $id = 0): array
    {
        $jsonParams = json_decode($bodyParams, true);
        $validation = $this->getValidator()->validate($jsonParams, $id);
        if ($validation['success']) {
            $producTypeObject = new ProductType($jsonParams['name'], $jsonParams['taxPercentage'], $id);
            $result = null;
            if ($id) {
                $result = $this->update($producTypeObject); 
            } else {
                $result = $this->create($producTypeObject);
            }
            return $result;
        }

        return $validation;
    }
    /**
     * Method responsible for creating new product types
     *
     * @param string $bodyParams
     * @return array ProductType object formatted as array 
     */
    public function create(ProductType $productType): array
    {
        $created = $this->getRepository()->create($productType);
        return $created;
    }


    /**
     * Method responsible for update product types
     *
     * @param string $bodyParams
     * @return array ProductType object formatted as array 
     */
    public function update(ProductType $productType): array
    {
        $created = $this->getRepository()->update($productType);
        return $created;
    }

    public function delete(int $id) : array
    {
        $validation = $this->getValidator()->validateDelete($id);
        if ($validation['success']){
            $deleted = $this->getRepository()->delete($id);
            return $deleted;
        }
        return $validation;
    }

    /**
     * Method responsible for return an instance of the repository
     *
     * @return ProductTypeRepository
     */
    private function getRepository(): ProductTypeRepository
    {
        if (!isset($this->repository)) {
            $this->repository = new ProductTypeRepository();
        }
        return $this->repository;
    }

    private function getValidator(): ProductTypeValidator
    {
        if (!isset($this->validator)) {
            $this->validator = new ProductTypeValidator($this->getRepository());
        }
        return $this->validator;
    }
}