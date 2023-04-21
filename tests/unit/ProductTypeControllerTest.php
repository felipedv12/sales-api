<?php
namespace App\Tests\Unit;
use App\Controllers\ProductTypeController;
use PHPUnit\Framework\TestCase;

class ProductTypeControllerTest extends TestCase
{
    private $controller;

    protected function setUp() : void
    {
        $this->controller = new ProductTypeController();
    }

    
}