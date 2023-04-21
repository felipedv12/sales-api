<?php
namespace App\Entities;

use App\Utils\Consts;
use DateTime;
use DateTimeZone;

/**
 * Product entity
 */
class Product implements Entity
{
    private ?int $id;
    private string $name;
    private string $barcode;
    private ?string $description;
    private float $price;
    private ProductType $productType;
    private ?DateTime $createdAt;
    private ?DateTime $updatedAt;

    public function __construct()
    {
        $dateTime = new DateTime('now', new DateTimeZone(Consts::DATE_TIMEZONE));
        $this->createdAt = $dateTime;
        $this->updatedAt = $dateTime;
    }

    /**
     * Creates a new Product object
     *
     * @param integer|null $id
     * @param string $name
     * @param string $barcode
     * @param string|null $description
     * @param float $price
     * @param ProductType $productType
     * @param string|null $createdAt
     * @param string|null $updatedAt
     * @return void
     */
    public function allParams(?int $id, string $name, string $barcode, ?string $description, float $price, ProductType $productType, ?string $createdAt, ?string $updatedAt)
    {
        $dateTime = new DateTime('now', new DateTimeZone(Consts::DATE_TIMEZONE));
        $this->id = $id;
        $this->name = $name;
        $this->barcode = $barcode;
        $this->description = $description;
        $this->price = $price;
        $this->productType = $productType;
        $this->createdAt = $createdAt ? new DateTime($createdAt) : $dateTime;
        $this->updatedAt = $updatedAt ? new DateTime($updatedAt) : $dateTime;
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
     * Get the value of barcode
     *
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
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
     * Get the value of createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        if (!isset($this->createdAt)) {
            return new DateTime('now', new DateTimeZone(Consts::DATE_TIMEZONE));
        }
        return $this->createdAt;
    }

    /**
     * Get the value of updatedAt
     *
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        if (!isset($this->createdAt)) {
            return new DateTime('now', new DateTimeZone(Consts::DATE_TIMEZONE));
        }
        return $this->updatedAt;
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

    /**
     * Set properties
     *
     * @param string $property
     * @param mixed $value
     * @return void
     */
    public function set(string $property, mixed $value): void
    {
        $this->$property = $value;
    }

    /**
     * Get the class type of the Product Type relation
     *
     * @return string
     */
    public function productTypeClass(): string
    {
        return ProductType::class;
    }
}