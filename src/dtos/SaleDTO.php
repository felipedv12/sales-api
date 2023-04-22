<?php
namespace App\DTOs;
use App\Entities\Sale;

class SaleDTO extends DTOEntity
{
    public float $totalProductValue;
    public float $totalTaxValue;
    public array $items;
    public string $createdAt;
    public string $updatedAt;

    /**
     * Returns the entity for the DTO
     *
     * @return Sale
     */
    public function toEntity() : Sale
    {
        return new Sale($this);
    }

}