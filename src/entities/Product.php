<?php
namespace App\Entities;

/**
 * Product entity
 */
class Product extends Entity
{
    private ?int $id;
    private string $name;
    private string $barcode;
    private ?string $description;
    private float $price;
    private ProductType $productType;

    /**
     * Creates a new Product object
     *
     * @param integer|null $id
     * @param string $name
     * @param string $barcode
     * @param string|null $description
     * @param float $price
     * @param ProductType $productType
     */
    public function __construct(?int $id, string $name, string $barcode, ?string $description, float $price, ProductType $productType)
    {
        $this->id = $id;
        $this->name = $name;
        $this->barcode = $barcode;
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

    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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