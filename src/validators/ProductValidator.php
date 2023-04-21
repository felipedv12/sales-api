<?php
namespace App\Validators;

use App\Repositories\ProductRepository;

class ProductValidator extends Validator
{
    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository);
    }

    public function validate(array $params, int $id): array
    {
        $this->initializeValidationProperties();
        if ($id) {
            $this->validateIfIdExists($id);
        }

        $this->validateEmptyString('name', $params['name']);
        $this->validateMaxCharacters('name', $params['name'], 100);

        $this->validateEmptyString('barcode', $params['barcode']);
        $this->validateMaxCharacters('barcode', $params['barcode'], 100);

        $this->validateMaxCharacters('description', $params['description'], 255);

        $this->validateEmptyNumeric('price', $params['price']);

        $this->validatePositiveNumeric('price', $params['price']);

        $this->validateEmptyArray('productType', $params['productType']);

        $this->validateEmptyNumeric('product-id', $params['productType']['id']);

        $this->validateUniqueField('barcode', 'barcode', $params['barcode'], $id);

        return $this->getValidationResults($params);
    }

    public function validateDelete(int $id) : array
    {
        $this->initializeValidationProperties();

        $this->validateIfIdExists($id);

        return $this->getValidationResults(['product-id' => $id]);
    }
}