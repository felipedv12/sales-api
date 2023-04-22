<?php
namespace App\Services;
use App\DTOs\SaleDTO;
use App\Entities\Sale;
use App\Repositories\SaleRepository;
use App\Validators\SaleValidator;

class SaleService extends Service
{
    protected function getEntityClass(): string
    {
        return Sale::class;
    }

    protected function getRepositoryClass(): string
    {
        return SaleRepository::class;
    }

    protected function getValidatorClass(): string 
    {
        return SaleValidator::class;
    }

    protected function getDTOClass(): string 
    {
        return SaleDTO::class;
    }
}