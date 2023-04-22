<?php
namespace App\Controllers;
use App\Services\ProductTypeService;

class ProductTypeController extends Controller
{
    /**
     * Returns the service class to be used by the controller
     *
     * @return string
     */
    protected function getServiceClass(): string 
    {
        return ProductTypeService::class;
    }
}