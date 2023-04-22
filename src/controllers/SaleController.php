<?php
namespace App\Controllers;
use App\Services\SaleService;

class SaleController extends Controller
{
    /**
     * Returns the service class to be used by the controller
     *
     * @return string
     */
    protected function getServiceClass(): string
    {
        return SaleService::class;
    }

    /**
     * Saves the sale in the database
     *
     * @param string $params
     * @return array
     */
    public function saveSale(string $params): array
    {   
        $paramsArray = json_decode($params, true);
        $result = $this->getService()->persistSale($paramsArray);

        return $result;
    }
}