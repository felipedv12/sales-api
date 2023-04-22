<?php
namespace App\DTOs;
use App\Entities\Entity;

abstract class DTOEntity {
    public ?int $id;

    /**
     * Returns the entity for the DTO
     *
     * @return Entity
     */
    abstract public function toEntity() : Entity;
}