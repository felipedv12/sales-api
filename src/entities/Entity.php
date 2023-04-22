<?php
namespace App\Entities;
use App\DTOs\DTOEntity;

interface Entity 
{
    /**
     * Returns the DTO for the entity
     *
     * @return DTOEntity
     */
    public function toDTO() : DTOEntity;
}
