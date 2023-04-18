<?php
namespace App\Models;
/**
 * Product entity
 */
class Product
{
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private ProductType $productType;
}
