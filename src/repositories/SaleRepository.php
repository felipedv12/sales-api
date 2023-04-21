<?php
namespace App\Repositories;

use App\Entities\Entity;
use App\Entities\Sale;
use App\Utils\Consts;

class SaleRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getInsertStatement(): string
    {   
        return 'INSERT INTO public.sale(
            total_product_value, total_tax_value, created_at, updated_at)
            VALUES (:total_product_value, :total_tax_value,  :created_at, :updated_at)
            RETURNING id;';
    }

    protected function getUpdateStatement(): string
    {
        return 'UPDATE public.sale
        SET total_product_value=:total_product_value, total_tax_value=:total_tax_value, updated_at=:updated_at
        WHERE id=:id;';
    }

    protected function getListStatement(): string
    {
        return 'SELECT id, total_product_value, total_tax_value, created_at, updated_at
        FROM public.sale';
    }

    protected function getFindByIdStatement(): string
    {
        return 'SELECT id, total_product_value, total_tax_value, created_at, updated_at
        FROM public.sale 
        WHERE p.id = :id;';
    }

    protected function getDeleteByIdStatement(): string
    {
        return 'DELETE FROM public.sale
        WHERE id=:id;';
    }

    protected function getInsertParams(Entity $entity): array
    {
        return [
            'total_product_value' => $entity->getTotalProductValue(),
            'total_tax_value' => $entity->getTotalTaxValue(),
            'created_at' => $entity->getCreatedAt()->format(Consts::DATE_FORMAT_DATABASE),
            'updated_at' => $entity->getUpdatedAt()->format(Consts::DATE_FORMAT_DATABASE)
        ];
    }

    protected function getUpdateParams(Entity $entity): array
    {
        return [
            'total_product_value' => $entity->getTotalProductValue(),
            'total_tax_value' => $entity->getTotalTaxValue(),
            'updated_at' => $entity->getUpdatedAt()->format(Consts::DATE_FORMAT_DATABASE),
            'id' => $entity->getId()
        ];
    }

    protected function getListMapping(array $result): Entity
    {
        $entity = new Sale();
        $entity->allParams(
            $result['id'],
            $result['total_product_value'],
            $result['total_tax_value'],
            $result['created_at'],
            $result['updated_at']
        );
        return $entity;
    }

}