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
    private bool $allowDelete = false;
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
        $this->id = $dto->id ?? 0;
        $this->name = $dto->name;
        $this->barcode = $dto->barcode;
        $this->description = $dto->description ?? null;
        $this->price = $dto->price;
        $this->productType = $dto->productType->toEntity();
        $this->setCreatedAt($dto->createdAt ?? null);
        $this->setUpdatedAt($dto->updatedAt ?? null);
        $this->allowDelete = $dto->allowDelete;
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
     * Get the value of allowDelete
     */ 
    public function getAllowDelete()
    {
        return $this->allowDelete;
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
     * Sets the timestamp created_at
     *
     * @param string|null $date
     * @return void
     */
    private function setCreatedAt(?string $date)
    {
        $dateTime = new DateTime('now', new DateTimeZone(Consts::DATE_TIMEZONE));
        if (isset($date)) {
            $createdAt = DateTime::createFromFormat('d/m/Y H:i:s', $date);
            if (!$createdAt) {
                $createdAt = new DateTime($date);
            }
            $this->createdAt = $createdAt ?? $dateTime;
        } else {
            $this->createdAt = $dateTime;
        }
    }

    /**
     * Sets the timestamp updated_at
     *
     * @param mixed $date
     * @return void
     */
    private function setUpdatedAt(mixed $date): void
    {
        $dateTime = new DateTime('now', new DateTimeZone(Consts::DATE_TIMEZONE));
        if (isset($dto->updatedAt)) {
            $updatedAt = DateTime::createFromFormat('d/m/Y H:i:s', $date);
            if (!$updatedAt) {
                $updatedAt = new DateTime($date);
            }
            $this->updatedAt = $updatedAt ?? $dateTime;
        } else {
            $this->updatedAt = $dateTime;
        }
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
        $dto->allowDelete = $this->getAllowDelete();
        $dto->productType = $this->getProductType()->toDTO();
        $dto->createdAt = $this->getCreatedAt()->format(Consts::DATE_FORMAT_EXIBITION);
        $dto->updatedAt = $this->getUpdatedAt()->format(Consts::DATE_FORMAT_EXIBITION);

        return $dto;
    }
}