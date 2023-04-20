<?php
namespace App\Entities;

/**
 * Purchase entity
 */
class Purchase extends Entity
{
    private int $id;
    private Product $product;
    private float $purchasedAmount;
    private float $totalProductValue; // read-only
    private float $totalTaxValue; // read-only
    private float $totalPurchaseValue; // calculated property

    /**
     * Creates a new Purchase object.
     *
     * @param int $id The unique ID of the purchase.
     * @param Product $product The product that was purchased.
     * @param float $purchasedAmount The amount of the product that was purchased.
     * @param float $totalProductValue The total value of the product (excluding taxes).
     * @param float $totalTaxValue The total value of the taxes.
     */
    public function __construct(
        int $id,
        Product $product,
        float $purchasedAmount,
        float $totalProductValue,
        float $totalTaxValue
    ) {
        $this->id = $id;
        $this->product = $product;
        $this->purchasedAmount = $purchasedAmount;
        $this->totalProductValue = $totalProductValue;
        $this->totalTaxValue = $totalTaxValue;
        $this->totalPurchaseValue = $totalProductValue + $totalTaxValue;
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
     * Gets the product that was purchased.
     *
     * @return Product The purchased product.
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * Gets the amount of the product that was purchased.
     *
     * @return float The purchased amount.
     */
    public function getPurchasedAmount(): float
    {
        return $this->purchasedAmount;
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
    public function getTotalPurchaseValue(): float
    {
        return $this->totalPurchaseValue;
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
}