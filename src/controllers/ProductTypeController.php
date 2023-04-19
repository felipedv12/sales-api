<?php
namespace App\Controllers;
use App\Services\ProductTypeService;

class ProductTypeController
{
    private ProductTypeService $service;

    /**
     * Returns the object array with product types
     *
     * @return array Array containing ProductType objects
     */
    public function list(): array
    {
        $status = 200;
        $results = $this->getService()->list();
        if(empty($results['data'])){
            $status = 404;
        }
        http_response_code($status);
        return $results;
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return array
     */
    public function find(int $id): array
    {
        $status = 200;
        $results = $this->getService()->find($id);
        if(empty($results['data'])){
            $status = 404;
        }
        http_response_code($status);
        return $results;
    }

    /**
     * Create a new register of Product Type
     *
     * @param string $bodyParams Body params received via POST 
     * @return array
     */
    public function create(string $bodyParams) : array
    {
        $status = 201;
        $result = $this->getService()->preparePersist($bodyParams);
        if(!isset($result['id'])){
            $status = 400;
        }
        http_response_code($status);
        return $result;
    }

    /**
     * Update a register of Product Type
     *
     * @param string $bodyParams Body params received via POST 
     * @return array
     */
    public function update(string $bodyParams, int $id) : array
    {
        $status = 200;
        $result = $this->getService()->preparePersist($bodyParams, $id);
        if(!isset($result['id'])){
            $status = 400;
        }
        http_response_code($status);
        return $result;
    }

    /**
     * Delete a product type from the database
     *
     * @param integer $id
     * @return array
     */
    public function delete(int $id): array
    {
        $status = 200;
        $results = $this->getService()->delete($id);
        if(!empty($results['errors'])){
            $status = $results['errors']['code'];
        }
        http_response_code($status);
        return $results;
    }

    /**
     * Method responsible for return an instance of the service
     *
     * @return ProductTypeService
     */
    private function getService(): ProductTypeService
    {
        if (!isset($this->service)) {
            $this->service = new ProductTypeService();
        }
        return $this->service;
    }
}