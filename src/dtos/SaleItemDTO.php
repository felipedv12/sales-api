<?php
namespace App\DTOs;
use App\Entities\SaleItem;

class SaleItemDTO extends DTOEntity
{
    public ProductDTO $product;
    public ?SaleDTO $sale;
    public int $itemNumber;
    public float $soldAmount;
    public float $productValue;
    public float $taxValue;

    /**
     * Returns the entity for the DTO
     *
     * @return SaleItem
     */
    public function toEntity() : SaleItem
    {
        return new SaleItem($this);
    }
}