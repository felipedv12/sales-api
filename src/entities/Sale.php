<?php
namespace App\Entities;

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
     * @param integer|null $id
     * @param float $totalProductValue
     * @param float $totalTaxValue
     * @param string|null $createdAt
     * @param string|null $updatedAt
     * @return void
     */
    public function allParams(
        ?int $id,
        float $totalProductValue,
        float $totalTaxValue,
        ?string $createdAt,
        ?string $updatedAt
    ) {
        $dateTime = new DateTime('now', new DateTimeZone(Consts::DATE_TIMEZONE));

        $this->id = $id;
        $this->totalProductValue = $totalProductValue;
        $this->totalTaxValue = $totalTaxValue;
        $this->createdAt = $createdAt ? new DateTime($createdAt) : $dateTime;
        $this->updatedAt = $updatedAt ? new DateTime($updatedAt) : $dateTime;
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
     * Get the object in array format
     *
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * Set an property in the class
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
}