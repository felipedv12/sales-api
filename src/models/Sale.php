<?php
namespace App\Models;

class Sale {
    private int $id;
    private Product $product;
    private float $purchasedAmount;
}