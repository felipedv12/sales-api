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
        if (!empty($result)) {
            if ($result->getId() !== $id) {
                $this->success = false;
                $this->errors['name'][] = ['message' => 'Product type name already exists.'];
            }

        }
    }
}