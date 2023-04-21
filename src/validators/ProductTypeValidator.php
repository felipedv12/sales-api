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

        $this->validateEmptyString('name', $params['name']);
        $this->validateMaxCharacters('name', $params['name'], 100);
        $this->validateEmptyNumeric('taxPercentage', $params['taxPercentage']);

        $this->validatePositiveNumeric('taxPercentage', $params['taxPercentage']);
        $this->validateUniqueField('name', 'name', $params['name'], $id);

        return $this->getValidationResults($params);
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

        return $this->getValidationResults(['product-type-id' => $id]);
    }
}