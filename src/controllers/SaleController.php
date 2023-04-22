<?php
namespace App\Controllers;
use App\Services\SaleService;

class SaleController extends Controller
{
    protected function getServiceClass(): string
    {
        return SaleService::class;
    }

    public function saveSale(string $params): array
    {   
        $paramsArray = json_decode($params, true);
        $this->getService()->persistSale($paramsArray);

        return [];
    }
}