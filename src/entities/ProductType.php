<?php
namespace App\Entities;

/**
 * Product Type entity
 */
class ProductType
{
    private ?int $id;
    private string $name;
    private float $taxPercentage;

    /**
     * Create a new product type object
     *
     * @param integer|null $id
     * @param string $name
     * @param float $taxPercentage
     */
    public function __construct(string $name, float $taxPercentage, ?int $id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->taxPercentage = $taxPercentage;
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
     * Get the object in array format
     *
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}