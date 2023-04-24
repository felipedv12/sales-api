<?php
namespace App\Services;
use App\DTOs\ProductDTO;
use App\Entities\Product;
use App\Repositories\ProductRepository;
use App\Validators\ProductValidator;

class ProductService extends Service
{
    /**
     * Returns the entity to the service
     *
     * @return string
     */
    protected function getEntityClass(): string
    {
        return Product::class;
    }

    /**
     * Returns the repository to the service
     *
     * @return string
     */
    protected function getRepositoryClass(): string
    {
        return ProductRepository::class;
    }

    /**
     * Returns the validator to the service
     *
     * @return string
     */
    protected function getValidatorClass(): string 
    {
        return ProductValidator::class;
    }

    /**
     * Returns the DTO entity to the service
     *
     * @return string
     */
    protected function getDTOClass(): string
    {
        return ProductDTO::class;
    }
}