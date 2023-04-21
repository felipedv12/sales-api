<?php
namespace App\Entities;

class SaleItem implements Entity
{
    private ?int $id;
    private Product $product;
    private Sale $sale;
    private ?int $itemNumber;
    private float $soldAmount;
    private float $productValue;
    private float $taxValue;


    /**
     * Creates a new Sale Item
     *
     * @param integer|null $id
     * @param Product $product
     * @param Sale $sale
     * @param integer|null $itemNumber
     * @param float $soldAmount
     * @param float|null $productValue
     * @param float|null $taxValue
     * @return void
     */
    public function allParams(?int $id, Product $product, Sale $sale, ?int $itemNumber, float $soldAmount, ?float $productValue, ?float $taxValue): void
    {
        $this->id = $id;
        $this->product = $product;
        $this->itemNumber = $itemNumber;
        $this->soldAmount = $soldAmount;
        $this->productValue = $productValue ?? ($this->product->getPrice() * $soldAmount);
        $this->taxValue = $taxValue?? ($this->product->getProductType()->getTaxPercentage() * $this->productValue / 100);
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
    public function getSale(): Sale
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

    public function set(string $property, mixed $value): void
    {
        $this->$property = $value;
    }

    public function toArray()
    {
        $array = get_object_vars($this);
        if (isset($this->product)) {
            $array['product'] = $this->product->toArray();
        }

        if (isset($this->sale)) {
            $array['sale'] = $this->sale->toArray();
        }

        return $array;
    }


}