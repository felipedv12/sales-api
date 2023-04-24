<?php
namespace App\Repositories;

use App\DTOs\SaleItemDTO;
use App\Entities\Entity;

class SaleItemRepository extends Repository
{
    /**
     * Create the object connection with the database, implemented in the parent
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns the insert statement for querying
     *
     * @return string
     */
    protected function getInsertStatement(): string
    {
        return 'INSERT INTO public.sale_item(
            product_id, sale_id, item_number, sold_amount, product_value, tax_value)
            VALUES (:product_id, :sale_id, :item_number, :sold_amount, :product_value, :tax_value)
            RETURNING id;';
    }

    /**
     * Returns the update statement for querying
     *
     * @return string
     */
    protected function getUpdateStatement(): string
    {
        return 'UPDATE public.sale_item
        SET product_id=:product_id, item_number=:item_number, sold_amount=:sold_amount, product_value=:product_value, tax_value=:tax_value
        WHERE id=:id;';
    }

    /**
     * Returns the select statement for querying
     *
     * @return string
     */
    protected function getListStatement(): string
    {
        return 'SELECT id, product_id, sale_id, item_number, sold_amount, product_value, tax_value
        FROM public.sale_item ';
    }

    /**
     * Returns the select statement for querying
     *
     * @return string
     */
    protected function getFindByIdStatement(): string
    {
        return 'SELECT id, product_id, sale_id, item_number, sold_amount, product_value, tax_value
        FROM public.sale_item
        WHERE id = :id;';
    }

    /**
     * Returns the delete statement for querying
     *
     * @return string
     */
    protected function getDeleteByIdStatement(): string
    {
        return 'DELETE FROM public.sale
        WHERE id=:id;';
    }

    /**
     * Maps the object with the params of the table
     *
     * @param Entity $entity
     * @return array
     */
    protected function getInsertParams(Entity $entity): array
    {
        return [
            'product_id' => $entity->getProduct()->getId(),
            'sale_id' => $entity->getSale()->getId(),
            'item_number' => $entity->getItemNumber(),
            'sold_amount' => $entity->getSoldAmount(),
            'product_value' => $entity->getProductValue(),
            'tax_value' => $entity->getTaxValue()
        ];
    }

    /**
     * Maps the object with the params of the table
     *
     * @param Entity $entity
     * @return array
     */
    protected function getUpdateParams(Entity $entity): array
    {
        return [
            'product_id' => $entity->getProduct()->getId(),
            'item_number' => $entity->getItemNumber(),
            'sold_amount' => $entity->getSoldAmount(),
            'product_value' => $entity->getProductValue(),
            'tax_value' => $entity->getTaxValue(),
            'id' => $entity->getId()
        ];
    }

    /**
     * Maps the database results with the entity
     *
     * @param array $result
     * @return Entity
     */
    protected function getListMapping(array $result): Entity
    {
        $productRepository = new ProductRepository();
        $product = $productRepository->findById($result['product_id'])['data'];
        $saleRepository = new SaleRepository();
        $sale = $saleRepository->findById($result['sale_id'])['data'];

        $dto = new SaleItemDTO();
        $dto->id = $result['id'];
        $dto->product = $product;
        $dto->sale = $sale;
        $dto->itemNumber = $result['item_number'];
        $dto->soldAmount = $result['sold_amount'];
        $dto->productValue = $result['product_value'];
        $dto->taxValue = $result['tax_value'];


        return $dto->toEntity();
    }



}