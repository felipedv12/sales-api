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
        return $this->getValidationResults($params);
    }
}