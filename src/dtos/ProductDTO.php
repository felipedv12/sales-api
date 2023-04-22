<?php
namespace App\DTOs;
use App\Entities\Product;

class ProductDTO extends DTOEntity
{
    public ?int $id;
    public string $name;
    public string $barcode;
    public ?string $description;
    public float $price;
    public ProductTypeDTO $productType;
    public string $createdAt;
    public string $updatedAt;

    /**
     * Returns the entity for the DTO
     *
     * @return Product
     */
    public function toEntity() : Product
    {
        return new Product($this);
    }

    /**
     * Get the class type of the Product Type relation
     *
     * @return string
     */
    public function productTypeClass(): string
    {
        return ProductTypeDTO::class;
    }
}