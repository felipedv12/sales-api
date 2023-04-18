<?php
namespace App\Models;

class ProductType
{
    private int $id;
    private string $name;
    private float $taxPercentage;

    /**
     * Create a new product type object
     *
     * @param integer $id The unique ID for the product type
     * @param string $name The name of the product type
     * @param float $taxPercentage The tax percentage of the product type
     */
    public function __construct(int $id, string $name, float $taxPercentage)
    {
        $this->id = $id;
        $this->name = $name;
        $this->taxPercentage = $taxPercentage;
    }

    

    /**
     * Get the unique ID of the product type
     *
     * @return int
     */
    public function getId(): int
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
}