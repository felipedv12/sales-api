<?php
namespace App\DTOs;
use App\Entities\SaleItem;

class SaleItemDTO extends DTOEntity
{
    public ProductDTO $product;
    public SaleDTO $sale;
    public int $itemNumber;
    public float $soldAmount;
    public float $productValue;
    public float $taxValue;

    public function toEntity() : SaleItem
    {
        return new SaleItem($this);
    }
}