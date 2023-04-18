<?php
namespace App\Entities;

/**
 * Product entity
 */
class Product
{
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private ProductType $productType;

    /**
     * Creates a new Product object
     *
     * @param int $id The unique ID of the product
     * @param string $name The name of the product
     * @param string $description An optional extended description of the product 
     * @param float $price Price of the product
     * @param ProductType $productType The type of the product
     */
    public function __construct(int $id, string $name, string $description, float $price, ProductType $productType)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->productType = $productType;
    }



    /**
     * Get the unique ID of the product
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the name of the product
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the description of the product
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get the price of the product
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Get the type of the product
     *
     * @return ProductType
     */
    public function getProductType(): ProductType
    {
        return $this->productType;
    }
}