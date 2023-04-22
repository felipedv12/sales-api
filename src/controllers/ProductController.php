<?php
namespace App\Controllers;
use App\Services\ProductService;

class ProductController extends Controller 
{
    /**
     * Returns the service class to be used by the controller
     *
     * @return string
     */
    protected function getServiceClass() : string 
    {
        return ProductService::class;
    }
}