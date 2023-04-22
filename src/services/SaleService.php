<?php
namespace App\Services;

use App\DTOs\SaleDTO;
use App\DTOs\SaleItemDTO;
use App\Entities\Sale;
use App\Entities\SaleItem;
use App\Repositories\ProductRepository;
use App\Repositories\SaleItemRepository;
use App\Repositories\SaleRepository;
use App\Validators\SaleValidator;

class SaleService extends Service
{
    protected function getEntityClass(): string
    {
        return Sale::class;
    }

    protected function getRepositoryClass(): string
    {
        return SaleRepository::class;
    }

    protected function getValidatorClass(): string
    {
        return SaleValidator::class;
    }

    protected function getDTOClass(): string
    {
        return SaleDTO::class;
    }

    /**
     * Begins the persistance of the sale
     *
     * @param array $params
     * @return array
     */
    public function persistSale(array $params): array
    {
        $validationResults = $this->validateParams($params);
        if (!$validationResults['success']) {
            return $validationResults;
        }

        $totalProductValue = 0;
        $totalTaxValue = 0;
        $items = $this->createSaleItemsDTO($params, $totalProductValue, $totalTaxValue);

        return $this->createSale($items, $totalProductValue, $totalTaxValue);

    }

    /**
     * Creates the objects of the items of the sale
     *
     * @param array $params
     * @param float $totalProductValue
     * @param float $totalTaxValue
     * @return array
     */
    private function createSaleItemsDTO(array $params, float &$totalProductValue, float &$totalTaxValue): array
    {
        $itemNumber = 1;
        $productRepository = new ProductRepository();
        $items = [];

        foreach ($params as $item) {
            $product = $productRepository->findById($item['product']['id'])['data'];
            // creates item with basic information
            $dto = new SaleItemDTO();
            $dto->product = $product;
            $dto->soldAmount = $item['soldAmount'];
            $dto->itemNumber = $itemNumber;

            // calculates the left params
            $saleItem = $dto->toEntity();
            $totalProductValue += $saleItem->getProductValue();
            $totalTaxValue += $saleItem->getTaxValue();

            // returns the complete dto
            array_push($items, $saleItem->toDTO());
            $itemNumber++;
        }
        return $items;
    }

    /**
     * Creates the sale object and persists in database
     *
     * @param array $items
     * @param float $totalProductValue
     * @param float $totalTaxValue
     * @return array
     */
    private function createSale(array $items, float $totalProductValue, float $totalTaxValue): array
    {
        $saleItemRepository = new SaleItemRepository();
        $sale = new SaleDTO();
        $sale->totalProductValue = $totalProductValue;
        $sale->totalTaxValue = $totalTaxValue;
        $result = $this->create($sale->toEntity());
        if (!$result['success']) {
            return $result;
        }
        $sale = $result['data'];
        $createdItems = [];
        foreach ($items as $item) {
            $item->sale = $sale;
            $created = $this->createSaleItem($item->toEntity(), $saleItemRepository);
            array_push($createdItems, $created);
        }

        return $createdItems;
    }

    /**
     * Validate the request params
     *
     * @param array $params
     * @return array
     */
    private function validateParams(array $params): array
    {
        foreach ($params as $item) {
            $validation = $this->getValidator()->validate($item, 0);
            if (!$validation['success']) {
                return $validation;
            }
        }

        return ['success' => true];
    }

    /**
     * Creates the item in the table
     *
     * @param SaleItem $entity
     * @param SaleItemRepository $repository
     * @return array
     */
    private function createSaleItem(SaleItem $entity, SaleItemRepository $repository): array
    {
        return $repository->create($entity);;
    }
}