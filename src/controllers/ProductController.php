<?php
namespace App\Controllers;
use App\Services\ProductService;

class ProductController extends Controller 
{
    protected function getServiceClass() : string 
    {
        return ProductService::class;
    }
}