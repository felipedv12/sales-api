<?php
namespace App\Entities;

/**
 * Sale entity
 */
class Sale implements Entity
{
    private ?int $id;
    private Product $product;
    private float $soldAmount;
    private float $totalProductValue; // read-only
    private float $totalTaxValue; // read-only
    private float $totalSaleValue; // calculated property

    /**
     * Creates a new Sale object.
     *
     * @param int $id The unique ID of the sale.
     * @param Product $product The product that was sold.
     * @param float $soldAmount The amount of the product that was sold.
     * @param float $totalProductValue The total value of the product (excluding taxes).
     * @param float $totalTaxValue The total value of the taxes.
     */
    public function allParams(
        ?int $id,
        Product $product,
        float $soldAmount,
        float $totalProductValue,
        float $totalTaxValue
    ) {
        $this->id = $id;
        $this->product = $product;
        $this->soldAmount = $soldAmount;
        $this->totalProductValue = $totalProductValue;
        $this->totalTaxValue = $totalTaxValue;
        $this->totalSaleValue = $totalProductValue + $totalTaxValue;
    }

    /**
     * Gets the unique ID of the purchase.
     *
     * @return int The ID of the purchase.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the product that was sold.
     *
     * @return Product The sold product.
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * Gets the amount of the product that was sold.
     *
     * @return float The sold amount.
     */
    public function getSaledAmount(): float
    {
        return $this->soldAmount;
    }

    /**
     * Gets the total value of the product (excluding taxes).
     *
     * @return float The total product value.
     */
    public function getTotalProductValue(): float
    {
        return $this->totalProductValue;
    }

    /**
     * Gets the total value of the taxes.
     *
     * @return float The total tax value.
     */
    public function getTotalTaxValue(): float
    {
        return $this->totalTaxValue;
    }

    /**
     * Gets the total purchase value (including taxes).
     *
     * @return float The total purchase value.
     */
    public function getTotalSaleValue(): float
    {
        return $this->totalSaleValue;
    }

    /**
     * Get the object in array format
     *
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function set(string $property, mixed $value): void
    {
        $this->$property = $value;
    }
}