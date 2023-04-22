<?php
namespace App\Validators;

use App\Repositories\ProductTypeRepository;
use App\Repositories\SaleRepository;
use App\Utils\Consts;

class SaleValidator extends Validator
{

    public function __construct(SaleRepository $repository)
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

        $this->validateEmptyArray('product', $params['product']);
        $this->validateEmptyNumeric('product-id', $params['product']['id']);

        $this->validateEmptyNumeric('soldAmount', $params['soldAmount']);
        $this->validatePositiveNumeric('soldAmount', $params['soldAmount']);

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

        return $this->getValidationResults(['sale-id' => $id]);
    }
}