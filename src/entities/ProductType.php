<?php
namespace App\Entities;

use App\DTOs\DTOEntity;
use App\DTOs\ProductTypeDTO;

/**
 * Product Type entity
 */
class ProductType implements Entity
{
    private ?int $id;
    private string $name;
    private float $taxPercentage;

    /**
     * Create a new ProductType object
     *
     * @param ProductTypeDTO $dto
     */
    public function __construct(ProductTypeDTO $dto)
    {
        $this->id = $dto->id;
        if(isset($dto->name)){
            $this->name = $dto->name;
        }
        if(isset($dto->taxPercentage)){
            $this->taxPercentage = $dto->taxPercentage;
        }
    }

    /**
     * Get the unique ID of the product type
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the name of the product type
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the tax percentage of the product type
     *
     * @return float
     */
    public function getTaxPercentage(): float
    {
        return $this->taxPercentage;
    }

    /**
     * Returns the DTO for the Entity
     *
     * @return DTOEntity
     */
    public function toDTO(): DTOEntity
    {
        $dto = new ProductTypeDTO();
        $dto->id = $this->getId();
        $dto->name = $this->getName();
        $dto->taxPercentage = $this->getTaxPercentage();
        return $dto;
    }
}