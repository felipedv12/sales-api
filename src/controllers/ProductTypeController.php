<?php
namespace App\Controllers;
use App\Services\ProductTypeService;

class ProductTypeController extends Controller
{
    protected function getServiceClass(): string 
    {
        return ProductTypeService::class;
    }
}