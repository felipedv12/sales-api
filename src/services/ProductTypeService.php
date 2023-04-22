<?php
namespace App\Services;

use App\DTOs\ProductTypeDTO;
use App\Entities\ProductType;
use App\Repositories\ProductTypeRepository;
use App\Validators\ProductTypeValidator;

class ProductTypeService extends Service
{
    /**
     * Returns the repository class
     *
     * @return string
     */
    protected function getRepositoryClass(): string
    {
        return ProductTypeRepository::class;
    }

    /**
     * Returns the entity class
     *
     * @return string
     */
    protected function getEntityClass(): string
    {
        return ProductType::class;
    }

    /**
     * Returns the validator class
     *
     * @return string
     */
    protected function getValidatorClass(): string
    {
        return ProductTypeValidator::class;
    }

    /**
     * Rerturns the DTO class
     *
     * @return string
     */
    protected function getDTOClass(): string 
    {
        return ProductTypeDTO::class;
    }

}