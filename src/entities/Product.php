<?php
namespace App\Entities;

use App\DTOs\DTOEntity;
use App\DTOs\ProductDTO;
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

    /**
     * Creates a new Product object
     *
     * @param ProductDTO $dto
     * @return void
     */
    public function __construct(ProductDTO $dto)
    {
        $dateTime = new DateTime('now', new DateTimeZone(Consts::DATE_TIMEZONE));
        $this->id = $dto->id;
        $this->name = $dto->name;
        $this->barcode = $dto->barcode;
        $this->description = isset($dto->description) ? $dto->description : null;
        $this->price = $dto->price;
        $this->productType = $dto->productType->toEntity();
        $this->createdAt = isset($dto->createdAt) ? new DateTime($dto->createdAt) : $dateTime;
        $this->updatedAt = isset($dto->updatedAt) ? new DateTime($dto->updatedAt) : $dateTime;
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
     * Returns the DTO for the Entity
     *
     * @return DTOEntity
     */
    public function toDTO(): DTOEntity
    {
        $dto = new ProductDTO();
        $dto->id = $this->getId();
        $dto->name = $this->getName();
        $dto->barcode = $this->getBarcode();
        $dto->description = $this->getDescription();
        $dto->price = $this->getPrice();
        $dto->productType = $this->getProductType()->toDTO();
        $dto->createdAt = $this->getCreatedAt()->format(Consts::DATE_FORMAT_EXIBITION);
        $dto->updatedAt = $this->getUpdatedAt()->format(Consts::DATE_FORMAT_EXIBITION);

        return $dto;
    }
}