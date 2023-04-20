<?php
namespace App\Validators;

use App\Repositories\ProductTypeRepository;
use App\Utils\Consts;

class ProductTypeValidator extends Validator
{
    
    public function __construct(ProductTypeRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Validate input data
     *
     * @param array $params
     * @param integer $id
     * @return array
     */
    public function validate(array $params, int $id): array
    {
        $this->initializeValidationProperties();

        if ($id) {
            $this->validateIfIdExists($id);
        }

        if ($this->success) {
            $this->validateEmptyString('name', $params['name']);
            $this->validateMaxCharacters('name', $params['name'], 100);
            $this->validateEmptyNumeric('taxPercentage', $params['taxPercentage']);
            
        }

        if ($this->success) {
            $this->validatePositiveNumeric('taxPercentage', $params['taxPercentage']);
            $this->validateUniqueName($params['name'], $id);
        }

        return ['code' => $this->code, 'success' => $this->success, 'data' => $params, 'errors' => $this->errors];
    }

    /**
     * Validate the product type before delete
     *
     * @param integer $id
     * @return array
     */
    public function validateDelete(int $id): array
    {
        $this->initializeValidationProperties();

        $this->validateIfIdExists($id);

        return ['code' => $this->code, 'success' => $this->success, 'data' => ['product-type-id' => $id], 'errors' => $this->errors];
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
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, 'name', 'Product type name already exists.');
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
}