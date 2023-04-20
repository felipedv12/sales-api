<?php
namespace App\Services;
use App\Entities\Product;
use App\Repositories\ProductRepository;
use App\Validators\ProductValidator;

class ProductService extends Service
{
    protected function getEntityClass(): string
    {
        return Product::class;
    }

    protected function getRepositoryClass(): string
    {
        return ProductRepository::class;
    }

    protected function getValidatorClass(): string 
    {
        return ProductValidator::class;
    }
}