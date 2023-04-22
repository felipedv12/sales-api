<?php
namespace App\Entities;
use App\DTOs\DTOEntity;

interface Entity 
{
    public function toDTO() : DTOEntity;
}
