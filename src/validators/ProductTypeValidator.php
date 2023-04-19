<?php
namespace App\Validators;

use App\Repositories\ProductTypeRepository;

class ProductTypeValidator
{

    private ProductTypeRepository $repository;

    private bool $success;

    private array $errors;

    public function __construct(ProductTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Validate input data
     *
     * @param mixed $params
     * @param integer $id
     * @return array
     */
    public function validate(mixed $params, int $id): array
    {
        $this->success = true;

        $this->errors = [
            'name' => [],
            'taxPercentage' => [],
        ];

        $this->validateName($params['name']);
        $this->validateTaxPercentage($params['taxPercentage']);
        if ($this->success) {
            $this->validateUniqueName($params['name'], $id);
        }

        return ['success' => $this->success, 'data' => $params, 'errors' => $this->errors];
    }

    /**
     * Validate the product type before delete
     *
     * @param integer $id
     * @return array
     */
    public function validateDelete(int $id) : array
    {
        $this->success = true;

        $this->errors = [];

        $this->validateIfExists($id);

        return ['success' => $this->success, 'data' => ['product-type-id' => $id], 'errors' => $this->errors];
    }

    /**
     * Validate name
     *
     * @param string|null $name
     * @return void
     */
    private function validateName(?string $name): void
    {
        if (empty($name)) {
            $this->success = false;
            $this->errors['name'][] = ['message' => '"name" must not be empty.'];
        }

        if (strlen($name) > 100) {
            $this->success = false;
            $this->errors['name'][] = ['message' => 'Max size of Name is 100 characters.'];
        }
    }


    /**
     * Validate tax percentage
     *
     * @param mixed $taxPercentage
     * @return void
     */
    private function validateTaxPercentage(mixed $taxPercentage): void
    {
        if ($taxPercentage === null) {
            $this->success = false;
            $this->errors['taxPercentage'][] = ['message' => '"taxPercentage" must not be empty.'];
        }

        if ($taxPercentage < 0) {
            $this->success = false;
            $this->errors['taxPercentage'][] = ['message' => '"taxPercentage" must not be negative.'];
        }
    }


    /**
     * Validate unique name
     *
     * @param string $name
     * @param int $id
     * @return void
     */
    private function validateUniqueName(string $name, int $id): void
    {
        $result = $this->repository->findByName($name);
        if (!empty($result['data'])) {
            if ($result['data']->getId() !== $id) {
                $this->success = false;
                $this->errors['name'][] = ['message' => 'Product type name already exists.'];
            }

        }
    }

    /**
     * Validate if product type is not linked to a product
     *
     * @param integer $id
     * @return boolean
     */
    private function validateProductTypeInUse(int $id): void 
    {

    }

    /**
     * Validate if the received ID exists in the database
     *
     * @param integer $id
     * @return void
     */
    private function validateIfExists(int $id) : void
    {
        $result = $this->repository->findById($id);
        if (empty($result['data'])){
            $this->success = false;
            $this->errors['code'] = 404; 
            $this->errors['message'] = 'Product type not found.';
        }
    }
}