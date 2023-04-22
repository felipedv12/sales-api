<?php
namespace App\DTOs;
use App\Entities\ProductType;

class ProductTypeDTO extends DTOEntity
{
    public string $name;
    public float $taxPercentage;

    /**
     * Returns the entity for the DTO
     *
     * @return ProductType
     */
    public function toEntity() : ProductType
    {
        return new ProductType($this);
    }

}