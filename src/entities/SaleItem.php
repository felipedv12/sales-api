<?php
namespace App\Entities;

use App\DTOs\DTOEntity;
use App\DTOs\SaleItemDTO;

class SaleItem implements Entity
{
    private ?int $id;
    private Product $product;
    private ?Sale $sale;
    private ?int $itemNumber;
    private float $soldAmount;
    private float $productValue;
    private float $taxValue;


    /**
     * Creates a new Sale Item
     *
     * @param SaleItemDTO $dto
     * @return void
     */
    public function __construct(SaleItemDTO $dto)
    {
        $this->id = $dto->id ?? 0;
        $this->product = $dto->product->toEntity();
        $this->sale = isset($dto->sale) ? $dto->sale->toEntity() : null;
        $this->itemNumber = $dto->itemNumber;
        $this->soldAmount = $dto->soldAmount;
        $this->productValue = $dto->productValue ?? ($this->product->getPrice() * $dto->soldAmount);
        $this->taxValue = $dto->taxValue ?? ($this->product->getProductType()->getTaxPercentage() * $this->productValue / 100);
    }

    /**
     * Get the value of id
     *
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of product
     *
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * Get the value of sale
     *
     * @return Sale
     */
    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    /**
     * Get the value of itemNumber
     *
     * @return int
     */
    public function getItemNumber(): int
    {
        return $this->itemNumber;
    }

    /**
     * Get the value of soldAmount
     *
     * @return float
     */
    public function getSoldAmount(): float
    {
        return $this->soldAmount;
    }

    /**
     * Get the value of productValue
     *
     * @return float
     */
    public function getProductValue(): float
    {
        return $this->productValue;
    }

    /**
     * Get the value of taxValue
     *
     * @return float
     */
    public function getTaxValue(): float
    {
        return $this->taxValue;
    }

    /**
     * Returns the DTO for the entity
     *
     * @return DTOEntity
     */
    public function toDTO(): DTOEntity
    {
        $dto = new SaleItemDTO();
        $dto->id = $this->getId();
        $dto->product = $this->getProduct()->toDTO();
        $dto->sale = isset($this->sale) ? $this->getSale()->toDTO() : null;
        $dto->itemNumber = $this->getItemNumber();
        $dto->soldAmount = $this->getSoldAmount();
        $dto->productValue = $this->getProductValue();
        $dto->taxValue = $this->getTaxValue();

        return $dto;
    }

}