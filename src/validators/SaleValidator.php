<?php
namespace App\Validators;

use App\Repositories\ProductTypeRepository;
use App\Repositories\SaleRepository;
use App\Utils\Consts;

class SaleValidator extends Validator
{
    /**
     * Passes the dependency to the Validator
     *
     * @param SaleRepository $repository
     */
    public function __construct(SaleRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Validates input data
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

        $this->validateEmptyArray('product', $params['product']);
        $this->validateEmptyNumeric('product-id', $params['product']['id']);

        $this->validateEmptyNumeric('soldAmount', $params['soldAmount']);
        $this->validatePositiveNumeric('soldAmount', $params['soldAmount']);

        return $this->getValidationResults($params);
    }

    /**
     * Validates the sale before delete
     *
     * @param integer $id
     * @return array
     */
    public function validateDelete(int $id): array
    {
        $this->initializeValidationProperties();

        $this->validateIfIdExists($id);

        return $this->getValidationResults(['sale-id' => $id]);
    }
}