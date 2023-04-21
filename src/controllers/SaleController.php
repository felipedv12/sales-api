<?php
namespace App\Controllers;
use App\Services\SaleService;

class SaleController extends Controller
{
    protected function getServiceClass(): string
    {
        return SaleService::class;
    }
}