<?php
namespace App\Entities;

use App\DTOs\DTOEntity;
use App\DTOs\SaleDTO;
use App\Utils\Consts;
use DateTime;
use DateTimeZone;

/**
 * Sale entity
 */
class Sale implements Entity
{
    private ?int $id;
    private float $totalProductValue;
    private float $totalTaxValue;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    /**
     * Creates a new Sale object
     *
     * @param SaleDTO $dto
     * @return void
     */
    public function __construct(SaleDTO $dto)
    {
        $this->id = $dto->id ?? 0;
        $this->totalProductValue = $dto->totalProductValue;
        $this->totalTaxValue = $dto->totalTaxValue;
        $this->setCreatedAt($dto->createdAt ?? null);
        $this->setUpdatedAt($dto->updatedAt ?? null);
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
     * Get the value of createdAt
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
        $dto = new SaleDTO();
        $dto->id = $this->getId();
        $dto->totalProductValue = $this->getTotalProductValue();
        $dto->totalTaxValue = $this->getTotalTaxValue();
        $dto->createdAt = $this->getCreatedAt()->format(Consts::DATE_FORMAT_EXIBITION);
        $dto->updatedAt = $this->getUpdatedAt()->format(Consts::DATE_FORMAT_EXIBITION);

        return $dto;
    }
}